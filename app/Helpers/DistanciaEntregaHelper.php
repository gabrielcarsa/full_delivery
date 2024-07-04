<?php

namespace App\Helpers;

class DistanciaEntregaHelper
{
    public static function getDistance($origem, $destino, $apiKey)
    {
        // URL da API de Distância do Google Maps
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origem}&destinations={$destino}&key={$apiKey}";

        // Fazendo a solicitação HTTP
        $response = file_get_contents($url);
        $data = json_decode($response);

        // Verificando se a solicitação foi bem-sucedida
        if ($data->status == 'OK') {
            // Obtendo a distância em metros
            $distance = $data->rows[0]->elements[0]->distance->value;
            return $distance;
        } else {
            return false;
        }
    }
}
