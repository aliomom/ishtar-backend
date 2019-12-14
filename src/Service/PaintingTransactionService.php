<?php


namespace App\Service;

use App\Controller\PaintingTransaction;
use App\Manager\PaintingTransactionManager;
use App\Manager\CreateUpdateDeleteManagerInterface;
use App\Manager\EntityArtTypeManager;
use App\Manager\EntityMediaManger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PaintingTransactionService implements PaintingTransactionServiceInterface
{

    private $paintingTransactionManager;
    private $artTypeManager;
    private $mediaManager;

    public function __construct(PaintingTransactionManager $paintingTransactionManager)
    {
        $this->paintingTransactionManager=$paintingTransactionManager;
    }

    public function create($request)
    {
        $paintingTransactionResult =$this->paintingTransactionManager->create($request);
        return $paintingTransactionResult;
    }
    //ToDO mapping painting entity and response
    public function update($request)
    {
        $paintingTransactionResult =$this->paintingTransactionManager->update($request);
        return $paintingTransactionResult;
    }
    public function getAll()
    {
        $result=$this->paintingTransactionManager->getAll();
        return $result;
    }
    public function delete($request)
    {
        $result=$this->paintingTransactionManager->delete($request);
        return $result;
    }

    public function getById($request)
    {
        return $result = $this->paintingTransactionManager->getById($request);
    }

}