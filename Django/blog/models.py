from django.db import models

class Post(models.Model):
	""" Init model Post """
	title   = models.CharField('Title', max_length=255, blank=False)
	content = models.TextField(verbose_name=u'Content')
	slug    = models.SlugField(blank=False, max_length=255, db_index= True, unique=True)
	date    = models.DateField(auto_now_add=False, auto_now=False, blank=True, verbose_name='Date')

	class Meta:
		ordering = ['-date']
