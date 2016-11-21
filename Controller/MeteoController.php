<?php
namespace MeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


class MeteoController extends Controller
{
	/**
	 * url '/'
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function homeAction(Request $request)
	{
		if($request->isMethod("post"))
		{
			if($request->get('lat') != "")
			{
				return $this->redirectToRoute('meteo_view_coord', array('lat' => $request->get('lat'), 'lon' => $request->get('lng')));
			}
			else
				return $this->redirectToRoute('meteo_view_city', array('city' => $request->get('city')));
		}
		return $this->render('MeteoBundle:Meteo:home.html.twig');
	}
	
	/**
	 * url '/view/{city}/{day}'
	 * 
	 * @param Request $request
	 * @param string|integer $city
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewCityAction(Request $request, $city, $day)
	{	
		try 
		{
			$dataCity = $this->checkCacheOrRequest($request, 'getForecastCityBy', $city);
		}
		catch(RequestException $e)
		{
			$request->getSession()->getFlashbag()->add('warning', 'The city cannot be found.');
			return $this->redirectToRoute('meteo_home');
		}
		$day = $day * 8;
		
		return $this->render('MeteoBundle:Meteo:viewCity.html.twig', array('data' => $dataCity, 'day' => $day, 'daysNames' => $this->createDaysNames()));
	}
	
	/**
	 * url '/view/lat={lat}lon={lon}/{day}'
	 * 
	 * @param Request $request
	 * @param float $lat
	 * @param float $lon
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewCoordAction(Request $request, $lat, $lon, $day)
	{
		$dataCity = $this->checkCacheOrRequest($request, 'getForecastCoord', $lat, $lon);
		
		$day = $day * 8;

		return $this->render('MeteoBundle:Meteo:viewCity.html.twig', array('data' => $dataCity, 'day' => $day, 'daysNames' => $this->createDaysNames()));
	}
	
	/**
	 * Cette fonction fait le lien entre le service de requête vers OpenWeatherMap,
	 * le système de mise en cache et les requetes générées par les utilisateurs
	 * 
	 * @param Request $request
	 * @param string $function 
	 * @param sring|float|integer $cityOrLat
	 * @param float $lon
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
	 */
	public function checkCacheOrRequest(Request $request, $function, $cityOrLat, $lon=null)
	{
		$cache = new FilesystemAdapter();
		
		if($lon != null)
			$dataCityCached = $cache->getItem('data'.$cityOrLat.$lon);
		else
			$dataCityCached = $cache->getItem('data'.$cityOrLat);
		
		if(!$dataCityCached->isHit())
		{
			if($lon != null)
				$dataCity = $this->container->get('meteo.open_weather_api')->$function($cityOrLat, $lon);
			else
			{
				if(is_numeric($cityOrLat))
					$function = $function.'Id';
				else
					$function = $function.'Name';
				
				$dataCity = $this->container->get('meteo.open_weather_api')->$function($cityOrLat);
			}
			
			$dataCityCached->set($dataCity);
			$dataCityCached->expiresAfter(3600);
			$cache->save($dataCityCached);
		}
		else
		{
			$dataCity = $dataCityCached->get();
		}
		
		return $dataCity;
	}
	
	/**
	 * Création des jours pour les onglets affichés sur la page d'une ville
	 * 
	 * @return array
	 */
	public function createDaysNames()
	{
		$date = new \Datetime();
		$daysNames = array();
		
		$date->add(new \DateInterval('P2D'));
		$daysNames[0] = $date->format('l');
		$date->add(new \DateInterval('P1D'));
		$daysNames[1] = $date->format('l');
		$date->add(new\DateInterval('P1D'));
		$daysNames[2] = $date->format('l');
		
		return $daysNames;
	}
}