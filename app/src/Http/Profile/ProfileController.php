<?php

namespace Src\Http\Profile;

use Doctrine\ORM\EntityManager;
use Src\CountryListProvider;
use Src\Entity\User;
use Src\Http\Controller;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends Controller
{
    public function __invoke(EntityManager $entityManager, Session $session): Response
    {
        $errors = [];

        try {
            $userData = $entityManager->getRepository(User::class)->findOneBy([
                'id' => $session->get('user')['id']
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $cache = new FilesystemAdapter();
        $countryList = $cache->getItem('country-list');
        if (!$countryList->isHit()) {
            $countryList->set(CountryListProvider::getCountryList());
            $countryList->expiresAfter(3600);
            $cache->save($countryList);
        }

        return $this->render('Profile.profile', [
            'countryList' => $countryList->get(),
            'userData' => $userData ?? [],
            'errors' => $errors,
            'timezoneApiKey' => $_ENV['TIMEZONE_API_KEY']
        ]);
    }
}