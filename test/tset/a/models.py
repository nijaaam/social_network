from __future__ import unicode_literals

from django.db import models

# Create your models here.
class users(models.Model):
    user_id  = models.AutoField(primary_key=True)
    email = models.EmailField(null=False)
    password      = models.CharField(max_length=60, null = False)
    securityQuestion      = models.CharField(max_length=240, null = False)
    securityAnswer      = models.CharField(max_length=240, null = False)

    class Meta:
        db_table = "users"

class photoCollection(models.Model):
    photoCollection_id  = models.AutoField(primary_key=True)
    user               = models.ForeignKey(users,  on_delete=models.CASCADE, null = False)
    
    class Meta:
        db_table = "photoCollection"

class photos(models.Model):
    photoID = models.AutoField(primary_key=True)
    photoCollectionId = models.ForeignKey(photoCollection,  on_delete=models.CASCADE, null = False)
    name = models.CharField(max_length=60, null = False)
    caption = models.CharField(max_length=60, null = False)
    dateUploaded = models.DateTimeField()
    
    class Meta:
        db_table = "photos"

class photoComments(models.Model):
    commentId = models.AutoField(primary_key=True)
    photoId = models.ForeignKey(photos,  on_delete=models.CASCADE, null = False)
    byUserId = models.ForeignKey(users,  on_delete=models.CASCADE, null = False)
    comment = models.CharField(max_length=60, null = False)
    dateTime = models.DateTimeField()

    class Meta:
        db_table = "photoComments"

class contactInfo(models.Model):
    user_id  = models.OneToOneField(users, primary_key=True)
    mobileNo = models.IntegerField()
    landlineNo = models.IntegerField()
    email = models.EmailField(null=False)

    class Meta:
        db_table = "contactInfo"

class personalInfo(models.Model):
    user_id  = models.OneToOneField(users, primary_key=True)
    firstname = models.CharField(max_length=240, null = False)
    surname = models.CharField(max_length=240, null = False)
    gender = models.CharField(max_length=240, null = False)
    birthday = models.DateField()
    email = models.EmailField(null=False)

    class Meta:
        db_table = "personalInfo"

class settings(models.Model):
    user_id  = models.OneToOneField(users, primary_key=True)
    
    class Meta:
        db_table = "settings"

class generalSettings(models.Model):
    user_id  = models.OneToOneField(users, primary_key=True)
    language =  models.CharField(max_length=240, null = False)
    timezone =  models.CharField(max_length=240, null = False)
    country =  models.CharField(max_length=240, null = False)
    
    class Meta:
        db_table = "generalSettings"

class securitySettings(models.Model):
    user_id  = models.OneToOneField(users, primary_key=True)
    whocanseeblog =  models.CharField(max_length=240, null = False)
    whocanseeprofile =  models.CharField(max_length=240, null = False)
    limitNoVisiblePastPosts =  models.CharField(max_length=240, null = False)
    limitDateVisiblePosts =  models.CharField(max_length=240, null = False)    
    whoCanSendFriendRequests =  models.CharField(max_length=240, null = False)    
    visibleName =  models.CharField(max_length=240, null = False)    
    visiblePersonalInfo =  models.BooleanField()    
    visibleContactInfo =  models.BooleanField()        
    
    class Meta:
        db_table = "securitySettings"


class blogs(models.Model):
    blogID =  models.AutoField(primary_key=True)
    userID = models.ForeignKey(users,  on_delete=models.CASCADE, null = False)

    class Meta:
        db_table = "blogs"

class blogposts(models.Model):
    postID = models.AutoField(primary_key=True)
    blogID = models.ForeignKey(blogs,  on_delete=models.CASCADE, null = False)
    blogTitle = models.CharField(max_length=240 )
    dateTime = models.DateTimeField()
    blogPostBody = models.CharField(max_length=240 )

    class Meta:
        db_table = "blogposts"

class blogpostcomments(models.Model):
    commentId = models.AutoField(primary_key=True)
    byUserId = models.ForeignKey(users,  on_delete=models.CASCADE, null = False)
    blogId = models.ForeignKey(blogs,  on_delete=models.CASCADE, null = False)
    blogPostId = models.ForeignKey(blogposts,  on_delete=models.CASCADE, null = False)
    comment =  models.CharField(max_length=240 )
    dateTime =  models.DateTimeField()
    
    class Meta:
        db_table = "blogpostcomments"

