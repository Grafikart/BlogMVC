<?php
$tab=array(
			'accueil.html' => array(
								'nav'=>'default::index',
								
								),
			'accueil_:page:.html' => array(
								'nav'=>'default::index',
								'tParam'=>array('page')
								),
								
			'category_:id:.html' => array(
								'nav'=>'default::category',
								'tParam' => array('id')
								),	
			
			'category_:id:_:postsslug:' => array(
								'nav'=>'default::categoryDetail',
								'tParam' => array('id','postsslug'),
									'tParamHidden'=>array(
										'postsAction'=>'show'
									)
								),	
			 	
			
			'post_:postsslug:.html' => array(
								'nav'=>'default::index',
								'tParam' => array('postsslug'),
									'tParamHidden'=>array(
										'postsAction'=>'show'
									)
								),				
			 
			 'login' => array(
								'nav' => 'auth::login'
								),
			'private'=>array(
							
							'nav'=>'private::index',
							),
			
													
			'postadmin_:postsadminid:'=>array(
							'nav'=>'private::index',
							'tParam'=>array('postsadminid'),
								'tParamHidden'=>array(
									'postsadminAction'=>'edit'
								),
							),
							
			 
								
			//page 404 (page non trouve)
			'404' => array(
								'nav' => 'default::index',
								),
		
		);
