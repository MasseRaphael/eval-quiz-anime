<?php

namespace App\Controller;


use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VideoController extends AbstractController
{
    #[Route('/video', name: 'video')]
    public function index(Request $request, HttpClientInterface $client): JsonResponse
    {
        $error = [
            "message" => "Veuillez renseignez une urel d'image",
            "status" => 401
        ];
        $data = $request->request->all();

        try {
            $response = $client->request(
                'GET',
                "https://api.trace.moe/search?url=" . $data['imageUrl']
            );

            $statusCode = $response->getStatusCode();
            $content = $response->toArray();

            $this->downloadVideo($content['result'][0]['video']);

            $fullResponse = [
                "message" => "La vidéo a bien été téléchargé ",
                "status" => 201
            ];
            return new JsonResponse($fullResponse);
        } catch(\Exception $error) {
            return new JsonResponse($error);
        }
    }

    public function downloadVideo($link){
        $directory = "videos/";
        $filename = md5(uniqid()).".mp4";
        file_put_contents($directory.$filename, $link);
    }
}
