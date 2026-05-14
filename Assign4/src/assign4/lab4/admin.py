from django.contrib import admin
from .models import *

admin.site.register(Pets)
admin.site.register(Owners)
admin.site.register(Owns)
admin.site.register(Likes)
