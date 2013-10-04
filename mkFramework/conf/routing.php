<?php
$tab=array(
			'articles.html' => array(
								'nav'=>'article::list',
								
								),
			'articleDetail_:id:.html' =>  array(
								'nav'=>'article::show',
								'tParam' => array('id')
								),
			'articleEdit_:id:' =>  array(
								'nav'=>'article::edit',
								'tParam' => array('id')
								),					
			
			'taches' => array(
								'nav'=>'tache::list',
								),
			'taches_archives' => array(
								'nav'=>'tache::archivelist',
								),
			'tacheDetail_:id:' =>  array(
								'nav'=>'tache::show',
								'tParam' => array('id')
								),
			'tacheEdit_:id:' =>  array(
								'nav'=>'tache::edit',
								'tParam' => array('id')
								),	
			//page 404 (page non trouve)
			'404' => array(
								'nav' => 'article::list',
								),
		
		);
