# -*- coding: utf-8 -*-
from django.db 					import models
from django.contrib.auth.models import User
from datetime 					import datetime

class Categorie(models.Model):
	"""Category of Post"""
	name			= models.CharField(max_length=75, 	blank=False, 	null=False)
	slug 			= models.CharField(max_length=75, 	blank=True, 	null=True)
	post_count		= models.IntegerField(default=0, 	blank=True, 	null=True)

class Post(models.Model):
	"""Post messages"""
	user 			= models.ForeignKey(User, 			blank=True, 	null=True)
	categorie 		= models.ForeignKey(Categorie, 		blank=False, 	null=False, related_name = "posts")
	name			= models.CharField(max_length=75, 	blank=False, 	null=False)
	content			= models.TextField()
	created    	 	= models.DateTimeField(				blank=True, 	null=True)
	slug 			= models.CharField(max_length=75, 	blank=True, 	null=True)
	
	def save(self):
		if self.id is None:
			""" auto generate created date for new post """
			self.created = datetime.now()
			if len(self.slug) == 0 :
				""" generate simple slug if empty """
				self.slug = self.name.replace(" ", "-")

			super(Post, self).save()

class Comment(models.Model):
	"""Comment"""
	post 			= models.ForeignKey(Post, 			blank=False, null=False, related_name = "comments")
	username 		= models.CharField(max_length=75, 	blank=False, null=False)
	mail			= models.EmailField(			  	blank=False, null=False)
	content			= models.TextField()
	created    	 	= models.DateTimeField(				blank=False, null=False)




		