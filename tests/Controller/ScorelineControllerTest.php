<?php

namespace App\Tests\Controller;

use App\Entity\Scoreline;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ScorelineControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $scorelineRepository;
    private string $path = '/scoreline/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->scorelineRepository = $this->manager->getRepository(Scoreline::class);

        foreach ($this->scorelineRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Scoreline index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'scoreline[firstnote]' => 'Testing',
            'scoreline[secondscore]' => 'Testing',
            'scoreline[thirdnote]' => 'Testing',
            'scoreline[savingnote]' => 'Testing',
            'scoreline[replacingnote]' => 'Testing',
            'scoreline[competitor]' => 'Testing',
            'scoreline[aircraft]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->scorelineRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scoreline();
        $fixture->setFirstnote('My Title');
        $fixture->setSecondscore('My Title');
        $fixture->setThirdnote('My Title');
        $fixture->setSavingnote('My Title');
        $fixture->setReplacingnote('My Title');
        $fixture->setCompetitor('My Title');
        $fixture->setAircraft('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Scoreline');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scoreline();
        $fixture->setFirstnote('Value');
        $fixture->setSecondscore('Value');
        $fixture->setThirdnote('Value');
        $fixture->setSavingnote('Value');
        $fixture->setReplacingnote('Value');
        $fixture->setCompetitor('Value');
        $fixture->setAircraft('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'scoreline[firstnote]' => 'Something New',
            'scoreline[secondscore]' => 'Something New',
            'scoreline[thirdnote]' => 'Something New',
            'scoreline[savingnote]' => 'Something New',
            'scoreline[replacingnote]' => 'Something New',
            'scoreline[competitor]' => 'Something New',
            'scoreline[aircraft]' => 'Something New',
        ]);

        self::assertResponseRedirects('/scoreline/');

        $fixture = $this->scorelineRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstnote());
        self::assertSame('Something New', $fixture[0]->getSecondscore());
        self::assertSame('Something New', $fixture[0]->getThirdnote());
        self::assertSame('Something New', $fixture[0]->getSavingnote());
        self::assertSame('Something New', $fixture[0]->getReplacingnote());
        self::assertSame('Something New', $fixture[0]->getCompetitor());
        self::assertSame('Something New', $fixture[0]->getAircraft());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Scoreline();
        $fixture->setFirstnote('Value');
        $fixture->setSecondscore('Value');
        $fixture->setThirdnote('Value');
        $fixture->setSavingnote('Value');
        $fixture->setReplacingnote('Value');
        $fixture->setCompetitor('Value');
        $fixture->setAircraft('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/scoreline/');
        self::assertSame(0, $this->scorelineRepository->count([]));
    }
}
