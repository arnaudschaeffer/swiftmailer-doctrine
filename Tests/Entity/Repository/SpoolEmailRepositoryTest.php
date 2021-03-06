<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\SwiftmailerDoctrine\Tests\Entity;

use Fxp\Component\SwiftmailerDoctrine\Model\Repository\SpoolEmailRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * SpoolEmail Repository Tests.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SpoolEmailRepositoryTest extends TestCase
{
    public function testFindEmailsToSend(): void
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|SpoolEmailRepositoryInterface $repo */
        $repo = $this->getMockBuilder('Fxp\Component\SwiftmailerDoctrine\Entity\Repository\SpoolEmailRepository')
            ->disableOriginalConstructor()
            ->setMethods(['createQueryBuilder'])
            ->getMock()
        ;

        $q = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(['setParameter', 'getResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $q->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue([]))
        ;

        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $qb->expects($this->any())
            ->method('where')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('orderBy')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('setParameter')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($q))
        ;

        $repo->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($qb))
        ;

        $this->assertSame([], $repo->findEmailsToSend(1));
    }

    public function testRecover(): void
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|SpoolEmailRepositoryInterface $repo */
        $repo = $this->getMockBuilder('Fxp\Component\SwiftmailerDoctrine\Entity\Repository\SpoolEmailRepository')
            ->disableOriginalConstructor()
            ->setMethods(['getEntityManager', 'createQueryBuilder'])
            ->getMock()
        ;

        $q = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(['setParameter', 'execute'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $q->expects($this->any())
            ->method('setParameter')
            ->will($this->returnSelf())
        ;

        $em = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')->getMock();
        $em->expects($this->any())
            ->method('createQuery')
            ->will($this->returnValue($q))
        ;

        $repo->expects($this->any())
            ->method('getEntityManager')
            ->will($this->returnValue($em))
        ;

        $q = $this->getMockBuilder('\Doctrine\ORM\AbstractQuery')
            ->setMethods(['setParameter', 'getResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $q->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue([]))
        ;

        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $qb->expects($this->any())
            ->method('where')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('orderBy')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('setParameter')
            ->will($this->returnSelf())
        ;
        $qb->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($q))
        ;

        $repo->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($qb))
        ;

        $repo->recover(900);

        $this->assertSame([], $repo->findEmailsToSend(1));
    }
}
