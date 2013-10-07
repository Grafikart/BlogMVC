from django.db import models
from django.contrib.auth.models import User
from datetime import datetime

class Category(models.Model):
	""" Model Category """
	name = models.CharField('Name', max_length=255, blank=False)
	slug = models.SlugField(blank=False, max_length=255, db_index= True, unique=True)

	def __unicode__(self):
		return self.name


class Post(models.Model):
	""" Model Post """
	title    = models.CharField('Title', max_length=255, blank=False)
	content  = models.TextField(verbose_name=u'Content')
	slug     = models.SlugField(blank=False, max_length=255, db_index= True, unique=True)
	date     = models.DateField(auto_now_add=False, auto_now=False, blank=True, verbose_name='Date')
	category = models.ForeignKey(Category, blank = True, null = True)
	user     = models.ForeignKey(User, blank = True, null = True)

	def __unicode__(self):
		return self.title

	class Meta:
		ordering = ['-date']

class Comment(models.Model):
	""" Model Comment """
	post     = models.ForeignKey(Post,  blank = False, null = False)
	username = models.CharField(max_length=90, blank = False, null = False )
	mail     = models.EmailField(blank = False, null = False)
	message  = models.TextField(blank = False, null = False)
	created  = models.DateTimeField(auto_now=True, auto_now_add=True, blank = False, null = False)

	def __unicode__(self):
		return self.post.title + " - " + self.username