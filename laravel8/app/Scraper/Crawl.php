<?php

namespace App\Scraper;

use Goutte\Client;
use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\DomCrawler\Crawler;

class Crawl
{

    public function scrape()
    {

        $puppeteer = new Puppeteer();

        $browser = $puppeteer->launch();
        $page = $browser->newPage();
// Yêu cầu người dùng nhập thông tin công việc
        echo "Nhập thông tin công việc:\n";
        $job = readline("Job: ");
        $category = readline("Category: ");
        $city = readline("City: ");
        $category = strtolower(str_replace(" ", "%2C", $category));
        $city = strtolower(str_replace(" ", "%2C", $city));
        $url = 'https://www.workinfinland.com/en/open-jobs/?query=' . $job . '&category=' . $category . '&city=' . $city;
        $page->goto($url);
        $html = $page->content();
        $crawler = new Crawler($html);
         $crawler->filter('div[data-testid="job-list"] a.job-card')->each(function ($node) {
            $name = $node->filter('p.job-card__title')->text();
            $company = $node->filter('p.job-card__employerName')->text();
            $address = $node->filter('p.job-card__location')->text();
            $job = new \App\Models\Crawl();
            $job->name = $name;
            $job->employer = $company;
            $job->address = $address;
            $job->save();
        });
    }
}
