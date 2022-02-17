<?php

namespace App\Controller;


use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIController extends AbstractController
{
    private ObjectManager $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry->getManager();
    }

    #[Route('/api/questions', name: 'questions_list', methods: ['GET'])]
    public function Get(QuestionRepository $questionRepo){
        $questions = $questionRepo->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($questions, 'json', [
            'circular_reference_handler' => function ($object) {
            return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route('/api/questions/ajouter', name: 'post_question', methods: ['POST'])]
    public function Post(Request $request, HttpClientInterface $client)
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

        return new Response('ok', 201);

    }

    public function downloadVideo($link){
        $directory = "videos/";
        $filename = md5(uniqid()).".mp4";
        file_put_contents($directory.$filename, $link);
        $path = 'http://localhost:8000/'.$directory.$filename;
        return $path;
    }
}
