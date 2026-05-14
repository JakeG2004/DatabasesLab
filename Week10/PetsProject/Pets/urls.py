from django.urls import path
from . import views

app_name = "Pets"
urlpatterns = [
    # Basic pages
    path("", views.index, name="index"),

    # Table pages
    path("tables/pets/", views.pets_db, name="pets_db"),

    # API
    path("tables/pets/add_pet/", views.add_pet, name="add_pet"),
    path("tables/pets/delete_pet/<int:petId>/", views.delete_pet, name="delete_pet"),
    path("tables/pets/update_pet/<int:petId>/", views.update_pet, name="update_pet"),
]