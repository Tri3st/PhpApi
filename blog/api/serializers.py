from django.contrib.auth.models import Group, User
from blog.api.models import Blogpost, get_category_choices
from rest_framework import serializers


class UserSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = User
        fields = ['url', 'username', 'email', 'groups', 'posts']

class GroupSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Group
        fields = ['url', 'name']

class BlogPostSerializer(serializers.Serializer):
    id = serializers.IntegerField(read_only=True)
    title = serializers.CharField(required=True, max_length=100)
    category = serializers.ChoiceField(required=True, choices=get_category_choices, default='NEWS')
    content = serializers.TextField(required=True)
    image = serializers.CharField(required=False)
    author = serializers.CharField(required=True)
    created = serializers.DateTimeField(required=True, auto_now_add=True, read_only=True)

    def create(self, validated_data):
        return Blogpost.objects.create(**validated_data)
    
    class Meta:
        model = Post
        fields = ['title', 'category', 'content', 'image', 'author', 'created']
