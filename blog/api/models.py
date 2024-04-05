from django.db import models

# Create your models here.
CATEGORY_CHOICES = sorted(['NEWS', 'INTERESTING', 'PERSONAL', 'WORK', 'TECH', 'OTHER'])


def get_category_choices():
    return {i: i for i in CATEGORY_CHOICES}


class Blogpost(models.Model): 
    title = models.CharField(max_length=100)
    category = models.CharField(max_length=20, choices=get_category_choices)
    content = models.TextField()
    image = models.CharField(max_length=255, blank=True, null=True)
    author = models.CharField(max_length=100)
    created = models.DateTimeField(auto_now_add=True)

    class Meta:
        ordering = ['created']

