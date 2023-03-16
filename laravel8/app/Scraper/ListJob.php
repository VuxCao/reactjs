<?php

namespace App\Scraper;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\DatabaseManager;
class ListJob
{
    const PAGE_SIZE = 20;

    /**
     * @var DatabaseManager
     */
    protected $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }
    public function scrape(): void
    {
        $this->importJob();
    }
    public function getJobNumber()
    {
        $url = 'https://www.jobly.fi/en/jobs?search=&job_geo_location=&Search_jobs=Search%20jobs&lat=60.16985569999999&lon=24.938379&country=Suomi&administrative_area_level_1=Uusimaa';

        $client = new Client();
        $crawler = $client->request('GET', $url);
        $all = $crawler->filter('.view-header h1')->text();
        return ceil(intval(filter_var($all, FILTER_SANITIZE_NUMBER_INT)) / self::PAGE_SIZE);
    }

    public function importJob(): void
    {
// Lấy số lượng job
        $jobNum = $this->getJobNumber();

// Khởi tạo progress bar
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $jobNum);
        $progressBar->setMessage('Lấy các job name: ');
        $progressBar->setFormat("%message%\t\n%current%/%max% [%bar%] %percent:3s%%");
        $progressBar->start();
// Lấy danh sách các job name
        $this->deleteData();
        for ($i = 0; $i < $jobNum; $i++) {
            $url = 'https://www.jobly.fi/en/jobs?search=&job_geo_location=&Search_jobs=Search%20jobs&lat=60.16985569999999&lon=24.938379&country=Suomi&administrative_area_level_1=Uusimaa&page=' . $i;
            $client = new Client();
            $crawler = $client->request('GET', $url);

            // Lấy danh sách các job name trên trang hiện tại
            $crawler->filter('div.view-content div.views-row')->each(function ($row) {
                $jobName = $row->filter('.description span.recruiter-company-profile-job-organization');
                if ($jobName->count() > 0) {
                    $name = trim($jobName->text());
                    \App\Models\ListJob::firstOrCreate(['name' => $name]);
                }
            });
            $progressBar->setMessage('Import Job page '.$i);
            $progressBar->display();
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    public function deleteData(): void
    {
        $this->db->table('list_jobs')->delete();
// Thiết lập lại giá trị ID chạy lại từ 1
        $this->db->statement('ALTER TABLE list_jobs AUTO_INCREMENT = 1');
    }
}
