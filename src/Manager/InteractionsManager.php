<?php


namespace App\Manager;


use App\Entity\ClapEntity;
use App\Entity\CommentEntity;
use App\Entity\EntityInteractionEntity;
use App\Mapper\CommentMapper;
use App\Repository\ClapEntityRepository;
use App\Repository\CommentEntityRepository;
use App\Repository\EntityInteractionEntityRepository;
use App\Request\GetArtistRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class InteractionsManager
{
    private $entityManager;
    private $commentRepository;
    private $entityInteractionRepository;
    private $clapRepository;

    public function __construct(EntityManagerInterface $entityManagerInterface,EntityInteractionEntityRepository
    $interactionEntityRepository,CommentEntityRepository $commentRepository,ClapEntityRepository $clapRepository)
    {
        $this->entityManager = $entityManagerInterface;
        $this->entityInteractionRepository=$interactionEntityRepository;
        $this->clapRepository=$clapRepository;
        $this->commentRepository=$commentRepository;
    }

    public function deleteInteractions($request,$entity)
    {
        $id = $request->getId();
        $interactions = $this->entityInteractionRepository->getEntityInteraction($entity, $id);
        if ($interactions) {
        foreach ($interactions as $interaction)
            $this->entityManager->remove($interaction);
        $this->entityManager->flush();
    }
        else
        {
            $exception = new EntityException();
            $exception->entityNotFound($entity);
        }

    }
    public function deleteComments($request,$entity)
    {
        $id=$request->getId();
        $Comments = $this->commentRepository->getEntity($entity, $id);
        foreach ($Comments as $comment)
            $this->entityManager->remove($comment);
        $this->entityManager->flush();

    }
    public function deleteClaps(GetArtistRequest $request,$entity)
    {
        $id=$request->getId();
        $Claps = $this->clapRepository->getEntity($entity, $id);
        foreach ($Claps as $clap)
            $this->entityManager->remove($clap);
        $this->entityManager->flush();
    }
}
