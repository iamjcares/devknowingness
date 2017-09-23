<?php

use \HelloVideo\User as User;

class AdminRoutesTest extends TestCase {

	public function testAdmin(){
 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', '/admin');
 		$this->assertResponseOk();
  }

  public function testAdminVideos(){

 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', 'admin/videos');
 		$this->assertResponseOk();
    $this->assertViewHas('videos');
  }

  public function testAdminVideosID(){

 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', 'admin/videos/edit/1');
 		$this->assertResponseOk();
  }

  public function testAdminVideosCreate(){

 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', 'admin/videos/create');
 		$this->assertResponseOk();
  }

  public function testAdminVideosCategories(){

 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', 'admin/videos/categories');
 		$this->assertResponseOk();
    	$this->assertViewHas('video_categories');
  }

  public function testAdminVideosCategoriesEditID(){
    
 		$user = User::where('username', '=', 'admin')->first();
		$this->be($user);

 		$this->call('GET', 'admin/videos/categories/edit/11');
 		$this->assertResponseOk();
 	}
}