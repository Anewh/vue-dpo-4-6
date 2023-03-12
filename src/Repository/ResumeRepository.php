<?php

namespace App\Repository;

use App\Entity\Education;
use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resume>
 *
 * @method Resume|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resume|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resume[]    findAll()
 * @method Resume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    public function save(Resume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update(Resume $resume, Resume $newResume): void
    {
        $metadata = $this->getEntityManager()->getMetadataFactory()->getMetadataFor($this->getClassName());

        $fieldNames = $metadata->getFieldNames();
        unset($fieldNames[0]);

        foreach ($fieldNames as $field) {
            $field = ucfirst($field);
            $setter = 'set' . $field;
            $getter = 'get' . $field;

            $resume->$setter($newResume->$getter());
        }

        foreach ($resume->getEducations() as $education) {
            $resume->removeEducation($education);
        }

        foreach ($newResume->getEducations() as $newEducation) {
            $educationRepository = $this->getEntityManager()->getRepository(Education::class);

            $education = $educationRepository->findOneBy(['id' => $newEducation->getId()]);
            if ($education !== null) {
                $educationRepository->update($education, $newEducation);
            } else {
                $resume->addEducation($newEducation);
                $this->getEntityManager()->persist($newEducation);
//                $educationRepository->save($newEducation);
            }
        }

        $this->getEntityManager()->flush();
    }

    public function remove(Resume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
