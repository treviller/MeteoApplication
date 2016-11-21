<?php
namespace MeteoBundle\OpenWeatherMapInterface;

use Symfony\Component\BrowserKit\Request;

class OpenWeatherAPI
{
	protected $client;
	protected $baseURI = 'api.openweathermap.org/data/2.5/';
	
	public function __construct()
	{
		$this->client = new Client($this->baseURI);
	}
	
	public function getWeatherCityByName($city)
	{
		$uri = 'weather?q='.$city.'&APPID=c2341a1f4d6c60e80b45f9d0499ec3ef';
		
		return $this->processRequest($uri);
	}
	
	public function getForecastCityByName($city)
	{
		$uri = 'forecast?q='.$city.'&units=metric&APPID=c2341a1f4d6c60e80b45f9d0499ec3ef';
	
		return $this->processRequest($uri);
	}
	
	public function getForecastCityById($city)
	{
		$uri = 'forecast?id='.$city.'&units=metric&APPID=c2341a1f4d6c60e80b45f9d0499ec3ef';
	
		return $this->processRequest($uri);
	}

	public function getForecastCoord($lat, $lon)
	{
		$uri = 'forecast?lat='.$lat.'&lon='.$lon.'&units=metric&APPID=c2341a1f4d6c60e80b45f9d0499ec3ef';
	
		return $this->processRequest($uri);
	}
	
	protected function processRequest($uri)
	{
		$response = $this->client->send(new Request($uri, 'GET'));

		$body = $response->getBody();
			
		return json_decode($body, true);
	}
}
