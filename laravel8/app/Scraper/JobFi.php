<?php

namespace App\Scraper;

use Goutte\Client;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class JobFi
{
    const PAGE_SIZE = 20;

    public function scrape()
    {
        $jobs = \App\Models\ListJob::all();
        $jobNum = count($jobs);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $jobNum);
        $progressBar->setMessage('Import tat ca job detail: ');
        $progressBar->setFormat("%message%\t\n%current%/%max% [%bar%] %percent:3s%%");
        $progressBar->start();
        foreach ($jobs as $key => $job) {
            $company = $job->name;
            $company = Str::slug(strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $company)));

            $url = 'https://thehub.io/startups/' . $company;
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $companyInfo = [];
            $this->crawlInfo($crawler, $companyInfo);
            $this->crawlDetail($crawler, $companyInfo);
            $this->crawlBenifits($crawler, $companyInfo);
            $this->crawlOpenPositions($crawler, $companyInfo);
            $this->crawlTeam($crawler, $companyInfo);
            $this->saveJob($companyInfo, $company);
            $progressBar->setMessage('Import Job Detail ' . $key);
            $progressBar->display();
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    /**
     * @param $crawler
     * @param $companyInfo
     * @return void
     */
    public function crawlInfo($crawler, &$companyInfo): void
    {
        $crawler->filter('div.details__info table.key-value-list tr')->each(function ($row) use (&$companyInfo) {
            $key = trim($row->filter('.key-value-list__key')->text());
            $value = trim($row->filter('.key-value-list__value')->text());
            if ($key === 'Location') {
                $companyInfo['location'] = $value;
            } elseif ($key === 'Website') {
                $companyInfo['website'] = $value;
            } elseif ($key === 'Founded') {
                $companyInfo['founded'] = $value;
            } elseif ($key === 'Employees') {
                $companyInfo['employees'] = $value;
            } elseif ($key === 'Industries') {
                $companyInfo['industries'] = $value;
            } elseif ($key === 'Business model') {
                $companyInfo['business_model'] = $value;
            } elseif ($key === 'Funding state') {
                $companyInfo['funding_state'] = $value;
            }
        });
    }

    /**
     * @param $crawler
     * @param $companyInfo
     * @return void
     */
    public function crawlDetail($crawler, &$companyInfo): void
    {
        $jobName = $crawler->filter('div.details__text');
        if ($jobName->count() > 0) {
            $name = trim($jobName->text());
            $companyInfo['details'] = $name;
        }
    }

    /**
     * @param $crawler
     * @param $companyInfo
     * @return void
     */
    public function crawlBenifits($crawler, &$companyInfo): void
    {
        $crawler->filter('div.benefits div.benefits__items')->each(function ($row) use (&$companyInfo) {
            $companyInfo['benefits'][trim($row->filter('h5')->text())] = trim($row->filter('p')->text());
        });
    }

    /**
     * @param $crawler
     * @param $companyInfo
     * @return void
     */
    public function crawlOpenPositions($crawler, &$companyInfo): void
    {
        $crawler->filter('div.card-job-find-list__title')->each(function ($row) use (&$companyInfo) {
            $companyInfo['open_positions'][] = json_encode([
                'position' => trim($row->filter('span.card-job-find-list__position')->text()),
                'type' => trim($row->filter('div.bullet-inline-list')->text()),
            ]);
        });
    }

    /**
     * @param $crawler
     * @param $companyInfo
     * @return void
     */
    public function crawlTeam($crawler, &$companyInfo): void
    {
        $crawler->filter('div.card-person')->each(function ($row) use (&$companyInfo) {
            $pos = trim($row->filter('.card-person__position')->text());
            $name = trim($row->filter('h4')->text());
            $companyInfo['team'][] = json_encode([
                'position' => $pos,
                'name' => $name,
            ]);
        });
    }

    public function saveJob($companyInfo, $company)
    {
        try {
            if ($companyInfo) {
                \App\Models\JobFi::firstOrCreate(
                    [
                        'name' => $company,
                        'open_positions' => json_encode($companyInfo['open_positions']),
                        'location' => $companyInfo['location'],
                        'website' => $companyInfo['website'],
                        'founded' => $companyInfo['founded'],
                        'employees' => $companyInfo['employees'],
                        'industries' => $companyInfo['industries'],
                        'business_model' => $companyInfo['business_model'],
                        'funding_state' => $companyInfo['funding_state'],
                        'details' => $companyInfo['details'],
                        'benefits' =>  json_encode($companyInfo['benefits']),
                        'team' =>  json_encode($companyInfo['team'])
                    ]
                );
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
