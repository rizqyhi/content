<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 06/11/18
 * Time: 06.56
 */

namespace WebAppId\Content\Tests\Feature\Services;

use Illuminate\Http\Request;
use WebAppId\Content\Repositories\ContentCategoryRepository;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Services\Params\AddContentCategoryParam;
use WebAppId\Content\Tests\TestCase;
use WebAppId\Content\Tests\Unit\Repositories\ContentTest;

class ContentServiceTest extends TestCase
{
    private $contentService;
    private $contentRepositoryTest;
    private $contentCategoryRepository;
    
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }
    
    public function contentService(): ContentService
    {
        if ($this->contentService == null) {
            $this->contentService = $this->getContainer()->make(ContentService::class);
        }
        return $this->contentService;
    }
    
    public function contentRepositoryTest(): ContentTest
    {
        if ($this->contentRepositoryTest == null) {
            $this->contentRepositoryTest = $this->getContainer()->make(ContentTest::class);
        }
    
        return $this->contentRepositoryTest;
    }
    
    public function contentCategoryRepository(): ContentCategoryRepository
    {
        if ($this->contentCategoryRepository == null) {
            $this->contentCategoryRepository = $this->getContainer()->make(ContentCategoryRepository::class);
        }
        return $this->contentCategoryRepository;
    }
    
    public function testUpdateContentStatus(): void
    {
        $result = $this->contentRepositoryTest()->testAddContent();
        $status_id = $this->getFaker()->numberBetween(1, 4);
        $resultUpdateStatus = $this->getContainer()->call([$this->contentService(), 'updateContentStatusByCode'], ['code' => $result->code, 'status' => $status_id]);
        
        if ($resultUpdateStatus == null) {
            self::assertTrue(false);
        } else {
            self::assertTrue(true);
            self::assertEquals($status_id, $resultUpdateStatus->status_id);
        }
    }
    
    public function testPagingContent(): void
    {
        $contentRepositoryTest = $this->contentRepositoryTest();
        
        $paging = 12;
    
        for ($i = 0; $i < $paging + 10; $i++) {
            $result = $contentRepositoryTest->testAddContent();
            $categories = [];
            $categories[0] = '1';
    
            $contentCategoryData = new AddContentCategoryParam();
            $contentCategoryData->setUserId(1);
            $contentCategoryData->setContentId($result->id);
            $contentCategoryData->setCategoryId($categories[0]);
    
            $result['content_category'] = $this->getContainer()->call([$this->contentCategoryRepository(), 'addContentCategory'], ['addContentCategoryParam' => $contentCategoryData]);
        }
        
        $request = new Request();
        $request->q = "";
        $request->category = 'page';
    
        $result = $this->getContainer()->call([$this->contentService(), 'showPaginate'], ['paginate' => $paging, 'request' => $request]);
    
        self::assertCount($paging, $result);
    }
}