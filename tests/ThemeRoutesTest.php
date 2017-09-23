<?php

use \HelloVideo\User as User;

class ThemeRoutesTest extends TestCase {


	/*
	|--------------------------------------------------------------------------
	| Home Page Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/
		|-----------------------------------------------------
		*/
			
			public function testHome()
			{
				$response = $this->call('GET', '/');
				$this->assertEquals(200, $response->getStatusCode());
			}


	/*
	|--------------------------------------------------------------------------
	| Video Page Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/videos
		|-----------------------------------------------------
		*/

			public function testVideos(){
				$response = $this->call('GET', '/videos');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/videos/{page}
		|-----------------------------------------------------
		*/
			
			public function testVideosPage(){
				$response = $this->call('GET', '/videos/?page=2');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/videos/category/{category}
		|-----------------------------------------------------
		*/
			
			public function testVideosCategory(){
				$response = $this->call('GET', '/videos/category/animation');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/videos/category/{category}
		|-----------------------------------------------------
		*/
			// Need to add enough content to test for category pages in animation
	
			public function testVideosCategoryPage(){
				$response = $this->call('GET', '/videos/category/animation');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/videos/tag/{tag}
		|-----------------------------------------------------
		*/
			
			public function testVideosTag(){
				$response = $this->call('GET', '/videos/tag/animation');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/videos/tag/{tag}/{page}
		|-----------------------------------------------------
		*/
		// Need to add enough content to test for tag pages in animation
			
			public function testVideosTagPage(){
				$response = $this->call('GET', '/videos/tag/animation');
				$this->assertEquals(200, $response->getStatusCode());
			}


		/*
		|-----------------------------------------------------
		| Route: 	URL/video/{id}
		|-----------------------------------------------------
		*/
			
			public function testVideoId(){
				$response = $this->call('GET', '/video/20');
				$this->assertEquals(200, $response->getStatusCode());
			}

	/*
	|--------------------------------------------------------------------------
	| Favorite Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/favorites
		|-----------------------------------------------------
		*/

			public function testFavorites(){
				$user = User::where('username', '=', 'admin')->first();
				$this->be($user);

				$response = $this->call('GET', '/favorites');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/favorites/{page}
		|-----------------------------------------------------
		*/

			public function testFavoritesPage(){
				$user = User::where('username', '=', 'admin')->first();
				$this->be($user);
				$response = $this->call('GET', '/favorites/?page=2');
				$this->assertEquals(200, $response->getStatusCode());
			}

	/*
	|--------------------------------------------------------------------------
	| Page Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/posts
		|-----------------------------------------------------
		*/

			public function testPosts(){
				$response = $this->call('GET', '/posts');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/posts/{page}
		|-----------------------------------------------------
		*/

			public function testPostsPage(){
				$response = $this->call('GET', '/posts/?page=2');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/posts/{category}
		|-----------------------------------------------------
		*/

			public function testPostsCategory(){
				$response = $this->call('GET', '/posts/category/example-category-1');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/posts/{category}/{page}
		|-----------------------------------------------------
		*/

			public function testPostsCategoryPage(){
				$response = $this->call('GET', '/posts/category/example-category-1');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/post/{slug}
		|-----------------------------------------------------
		*/

			public function testPostsSlug(){
				$response = $this->call('GET', '/post/example-post-1');
				$this->assertEquals(200, $response->getStatusCode());
			}

	/*
	|--------------------------------------------------------------------------
	| Page Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/pages
		|-----------------------------------------------------
		*/

			public function testPages(){
				$response = $this->call('GET', '/pages');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/page/{slug}
		|-----------------------------------------------------
		*/

			public function testPageSlug(){
				$response = $this->call('GET', '/page/faq');
				$this->assertEquals(200, $response->getStatusCode());
			}


	/*
	|--------------------------------------------------------------------------
	| Search Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/search?value={value}
		|-----------------------------------------------------
		*/

			public function testSearch(){
				$response = $this->call('GET', '/search?value=animation');
				$this->assertEquals(200, $response->getStatusCode());
			}

	/*
	|--------------------------------------------------------------------------
	| Auth and Password Reset Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/login
		|-----------------------------------------------------
		*/

			public function testLogin(){
				$response = $this->call('GET', '/login');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	POST URL/login
		|-----------------------------------------------------
		*/

			public function testPostLoginSuccess(){
				$response = $this->call('POST', '/login', array('email' => 'admin', 'password' => 'password', '_token' => csrf_token()) );
				//dd($response); die();
 				$this->assertSessionHas('note_type', 'success');
 				$this->assertRedirectedTo('/');
			}

		/*
		|-----------------------------------------------------
		| Route: 	POST URL/login
		|-----------------------------------------------------
		*/

			public function testPostLoginError(){
				$response = $this->call('POST', '/login', array('email' => 'admin', 'password' => 'password123', '_token' => csrf_token()) );
 				$this->assertSessionHas('note_type', 'error');
 				$this->assertRedirectedTo('/login');
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/signup
		|-----------------------------------------------------
		*/

			public function testSignup(){
				$response = $this->call('GET', '/signup');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/logout
		|-----------------------------------------------------
		*/

			public function testLogout(){
				$user = User::where('username', '=', 'admin')->first();
				$this->be($user);

				$this->call('GET', '/signup');
 				$this->assertRedirectedTo('/');
			}


	/*
	|--------------------------------------------------------------------------
	| User and User Edit Routes
	|--------------------------------------------------------------------------
	*/
		/*
		|-----------------------------------------------------
		| Route: 	URL/user/{username}
		|-----------------------------------------------------
		*/

			public function testUserUsername(){
				$response = $this->call('GET', '/user/admin');
				$this->assertEquals(200, $response->getStatusCode());
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/user/{username}/edit
		|-----------------------------------------------------
		*/

			public function testUserUsernameEdit(){
				$user = User::where('username', '=', 'admin')->first();
				$this->be($user);

				$this->call('GET', '/user/admin/edit');
 				echo $this->assertResponseOk();
			}

		/*
		|-----------------------------------------------------
		| Route: 	URL/user/{username}/edit
		|-----------------------------------------------------
		*/

			public function testUserUsernameEditNoAccess(){

				$this->call('GET', '/user/admin/edit');
 				$this->assertResponseStatus(302);
 				
			}	
		
		// ADD The rest of the Test routes...
			
		// Route::post('user/{username}/update', 'ThemeUserController@update');
		// Route::get('user/{username}/billing', 'ThemeUserController@billing');
		// Route::get('user/{username}/cancel', 'ThemeUserController@cancel_account');
		// Route::get('user/{username}/resume', 'ThemeUserController@resume_account');
		// Route::get('user/{username}/update_cc', 'ThemeUserController@update_cc');
		// Route::post('user/{username}/update_cc', 'ThemeUserController@update_cc_store');
		// Route::get('renew_subscription', 'ThemeUserController@renew');

}