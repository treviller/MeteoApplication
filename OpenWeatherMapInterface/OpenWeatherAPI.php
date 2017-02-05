<?php
namespace MeteoBundle\OpenWeatherMapInterface;

use Symfony\Component\BrowserKit\Request;

class OpenWeatherAPI
{
	protected $client;
	protected $apiKey;
	protected $baseURI = 'api.openweathermap.org/data/2.5/';
	
	public function __construct($apiKey)
	{
		$this->client = new Client($this->baseURI);
		$this->apiKey = $apiKey;
	}
	
	public function getWeatherCityByName($city)
	{
		$uri = 'weather?q='.$city.'&APPID='.$this->apiKey;
		
		return $this->processRequest($uri);
	}
	
	public function getForecastCityByName($city)
	{
		$uri = 'forecast?q='.$city.'&units=metric&APPID='.$this->apiKey;
	
		return $this->processRequest($uri);
	}
	
	public function getForecastCityById($city)
	{
		$uri = 'forecast?id='.$city.'&units=metric&APPID='.$this->apiKey;
	
		return $this->processRequest($uri);
	}

	public function getForecastCoord($lat, $lon)
	{
		$uri = 'forecast?lat='.$lat.'&lon='.$lon.'&units=metric&APPID='.$this->apiKey;
	
		return $this->processRequest($uri);
	}
	
	protected function processRequest($uri)
	{
		$response = $this->client->send(new Request($uri, 'GET'));

		$body = $response->getBody();
			
		return json_decode($body, true);
	}
}
