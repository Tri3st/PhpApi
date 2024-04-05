from django.contrib.auth.models import Group, User
from rest_framework import serializers


class UserSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = User
        fields = ['url', 'username', 'email', 'groups', 'posts']

class GroupSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Group
        fields = ['url', 'name']

# TODO : finish
class PostSerializer(serializers.Serializer):
    id = serializers.IntegerField(read_only=True)
    title = serializer.CharField(required=False, allow_blank=True, max_length=100)
    category = 
    content
    image
    author
    created

