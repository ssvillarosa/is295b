<?php

class CompanyModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('CompanySeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('CompanyModel');
    }    

    public function test_getCompanies(){
        $expected = [
            1 => 'ABC Corp',
            2 => 'ADB Inc.',
            3 => 'New Era Comp',
        ];
        $companies = $this->obj->getCompanies();
        $this->assertNotEquals($companies,ERROR_CODE);
        $this->assertNotEmpty($companies);
        foreach ($companies as $company) {
                $this->assertEquals($expected[$company->id], $company->name);
        }
    }
    
    public function test_getCompanyById(){
        $id = 1;
        $expected = [
            1 => 'ABC Corp',
            2 => 'ADB Inc.',
            3 => 'New Era Comp',
        ];
        $company = $this->obj->getCompanyById($id);
        $this->assertNotEquals($company,ERROR_CODE);
        $this->assertNotEmpty($company);
        $this->assertEquals($expected[$id], $company->name);
    }
    
    public function test_addCompany(){
        $company = (object)[
            'name' => 'New Company',
            'contact_person' => 'Contact',
            'primary_phone' => '34234',
            'secondary_phone' => '34003',
            'address' => 'BGC',
            'website' => 'www.new-company.com',
            'industry' => 'Recruitment',
            'created_by' => '1',
            'is_deleted' => '0',
            'deleted_time' => null,
            'deleted_by' => null,
        ];
        $inserted_id = $this->obj->addCompany($company);
        $newCompany  = $this->obj->getCompanyById($inserted_id);
        $this->assertNotEquals($newCompany,ERROR_CODE);
        $this->assertEquals($newCompany->name, $company->name);       
    }
    
    public function test_updateCompany(){
        $company = (object)[
            'name' => 'BBS',
            'website' => 'www.bbs.com',
        ];
        $company1  = $this->obj->getCompanyById(1);
        $this->assertNotEquals($company1->name,$company->name);
        $result = $this->obj->updateCompany($company,1);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedCompany1 = $this->obj->getCompanyById(1);
        $this->assertEquals($updatedCompany1->name,$company->name);    
    }
    
    public function test_getCompanyCount(){
        $companyCount  = $this->obj->getCompanyCount();
        $this->assertEquals($companyCount, 4);    
    }
    
    public function test_deleteCompany(){
        $companyCount  = $this->obj->getCompanyCount(); 
        $this->obj->deleteCompany(5,1);
        $newCount  = $this->obj->getCompanyCount();
        $this->assertEquals($newCount, $companyCount-1);    
    }
}
