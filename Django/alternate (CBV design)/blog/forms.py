#-*- coding: utf-8 -*-
from django.forms import ModelForm
from blog.models import Comment

class CommentForm(ModelForm):
	class Meta:
		model = Comment