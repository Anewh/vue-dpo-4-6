<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Enum\ResumeStatus;
use App\Repository\ResumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(priority: 1000, format: 'json')]
class ResumeApiController extends AbstractController
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;
    private EntityManagerInterface $em;
    private ResumeRepository $resumeRepository;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->em = $em;
        $this->resumeRepository = $em->getRepository(Resume::class);
    }

    #[Route('/api/cv/', name: 'api_resume_get_all')]
    public function getAll(): JsonResponse
    {
        /** @var Resume[] $resumes */
        $resumes = $this->resumeRepository->findAll();

        return new JsonResponse($this->serializer->serialize($resumes, 'json'), json: true);
    }

    #[Route('/api/cv/add', name: 'api_resume_add')]
    public function add(Request $request): JsonResponse
    {
        /** @var Resume $resume */
        $resume = $this->serializer->deserialize($request->getContent(), Resume::class, 'json', [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['id', ['educations' => 'id']],
        ]);

        $errors = $this->validator->validate($resume);
        if (count($errors) > 0) {
            return $this->sendError((string)$errors);
        }

        foreach ($resume->getEducations() as $education) {
            $this->em->persist($education);
        }

        $this->resumeRepository->save($resume, true);
        return new JsonResponse(status: 200);
    }

    #[Route('/api/cv/{id}', name: 'api_resume_get')]
    public function get($id): JsonResponse
    {
        /** @var Resume $resume */
        $resume = $this->resumeRepository->findOneBy(['id' => $id]);

        return new JsonResponse($this->serializer->serialize($resume, 'json'), json: true);
    }

    #[Route('/api/cv/{id}/edit', name: 'api_resume_edit')]
    public function edit($id, Request $request): JsonResponse
    {
        $resume = $this->resumeRepository->findOneBy(['id' => $id]);
        if ($resume === null) {
            return $this->sendError('Resume with id=' . $id . ' not found');
        }

        /** @var Resume $newResume */
        $newResume = $this->serializer->deserialize($request->getContent(), Resume::class, 'json');

        $errors = $this->validator->validate($newResume);
        if (count($errors) > 0) {
            return $this->sendError((string)$errors);
        }

        $this->resumeRepository->update($resume, $newResume);
        return new JsonResponse(status: 200);
    }

    #[Route('/api/cv/{id}/status/update', name: 'api_resume_status_update')]
    public function updateStatus($id, Request $request, DecoderInterface $decoder): JsonResponse
    {
        $resume = $this->resumeRepository->findOneBy(['id' => $id]);

        $status = $decoder->decode($request->getContent(), 'json',)['status'];

        $errors = $this->validator->validate($resume, groups: ['status']);
        if (count($errors) > 0) {
            return $this->sendError((string)$errors);
        }

        $resume->setStatus($status);
        $this->resumeRepository->save($resume, true);

        return new JsonResponse(status: 200);
    }

    private function sendError(string $message): JsonResponse
    {
        return new JsonResponse(['error' => $message], Response::HTTP_BAD_REQUEST);
    }
}
