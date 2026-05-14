from django.urls import path
from . import views

app_name = "lab4"
urlpatterns = [
    # Basic pages
    path("", views.index, name="index"),
    path("index", views.index, name="index"),

    # Table pages
    path("tables/pets/", views.pets_db, name="pets_db"),
    path("tables/owners/", views.owners_db, name="owners_db"),
    path("tables/owns/", views.owns_db, name="owns_db"),
    path("tables/likes/", views.likes_db, name="likes_db"),
    path("tables/foods/", views.foods_db, name="foods_db"),
    path("tables/purchases/", views.purchases_db, name="purchases_db"),

    # API
    path("tables/pets/add_pet/", views.add_pet, name="add_pet"),
    path("tables/pets/delete_pet/<int:petId>/", views.delete_pet, name="delete_pet"),
    path("tables/pets/update_pet/<int:petId>/", views.update_pet, name="update_pet"),

    path("tables/owners/add_owner/", views.add_owner, name="add_owner"),
    path("tables/owners/delete_owner/<int:OID>/", views.delete_owner, name="delete_owner"),
    path("tables/owners/update_owner/<int:OID>/", views.update_owner, name="update_owner"),

    path("tables/owns/add_own/", views.add_own, name="add_own"),
    path("tables/owns/delete_own/<int:OID>/<int:PetID>", views.delete_own, name="delete_own"),
    path("tables/owns/update_own/<int:OID>/<int:PetID>", views.update_own, name="update_own"),

    path("tables/likes/add_like/", views.add_like, name="add_like"),
    path("tables/likes/delete_like/<int:PetID>/", views.delete_like, name="delete_like"),
    path("tables/likes/update_like/<int:PetID>/", views.update_like, name="update_like"),

    path("tables/foods/add/", views.add_food, name="add_food"),
    path("tables/foods/delete/<int:foodId>/", views.delete_food, name="delete_food"),
    path("tables/foods/update/<int:foodId>/", views.update_food, name="update_food"),

    path("tables/purchases/add/", views.add_purchase, name="add_purchase"),
    path("tables/purchases/delete/<int:pk>/", views.delete_purchase, name="delete_purchase"),
    path("tables/purchases/update/<int:pk>/", views.update_purchase, name="update_purchase"),
]