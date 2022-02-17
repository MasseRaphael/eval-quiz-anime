<?php

namespace App\Controller;


use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddQuestionController extends AbstractController
{
    private ObjectManager $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry->getManager();
    }
    #[Route('/api/questions/ajouter', name: 'post_question')]
    public function index(Request $request, HttpClientInterface $client)
    {

        $formData = json_decode($request->getContent(), true);

        $response = $client->request(
            'GET',
            "https://api.trace.moe/search?url=" . $formData['videos']
        );
        $content = $response->toArray();

        $video = $this->downloadVideo($content['result'][0]['video']);

        $question = new Question();

        $question->setTitle($formData['title']);
        $question->setCorrectAnswer($formData['correctAnswer']);
        $question->setVideos($video);
        $question->setAnswers($formData['answers']);

        $this->managerRegistry->persist($question);
        $this->managerRegistry->flush();

        return $this->json($question);

    }

    public function downloadVideo($link){
        $directory = "videos/";
        $filename = md5(uniqid()).".mp4";
        file_put_contents($directory.$filename, $link);
        $path = '/'.$directory.$filename;
        return $path;
    }
}
