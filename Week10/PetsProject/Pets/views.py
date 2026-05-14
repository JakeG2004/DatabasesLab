from django.shortcuts import render, redirect
from django.http import HttpResponse, JsonResponse, HttpRequest
from django.db.models import Q
from django.views.decorators.http import require_POST

import json

from .models import *

def index(request: HttpRequest) -> HttpResponse:
    return render(request, "Pets/home.html")

def pets_db(request: HttpRequest) -> HttpResponse:
    pets = Pets.objects.all()
    return render(request, "Pets/pets_db.html", {'pets': pets})

@require_POST
def add_pet(request: HttpRequest) -> HttpResponse:

    # Get POST data
    data = request.POST
    pet_name = data.get("pet_name")
    pet_age = data.get("pet_age")
    pet_street = data.get("pet_street")
    pet_city = data.get("pet_city")
    pet_zipcode = data.get("pet_zipcode")
    pet_state = data.get("pet_state")
    pet_type = data.get("pet_type")

    # Create new object
    new_pet = Pets(
        Name=pet_name,
        Age=pet_age,
        Street=pet_street,
        City=pet_city,
        ZipCode=pet_zipcode,
        State=pet_state,
        TypeofPet=pet_type
    )

    # Save it
    new_pet.save()

    return redirect('Pets:pets_db')

@require_POST
def delete_pet(request: HttpRequest, petId: int) -> JsonResponse:
    cur_pet = Pets.objects.filter(PetID=petId).first()

    if(not cur_pet):
        return JsonResponse({'status': 500})
    
    cur_pet.delete()
    return JsonResponse({'status': 200})

@require_POST
def update_pet(request: HttpRequest, petId: int) -> JsonResponse:
    cur_pet = Pets.objects.filter(PetID=petId).first()

    if(not cur_pet):
        return JsonResponse({'status': 500})
    
    try:
        data = json.loads(request.body)
    except json.JSONDecodeError:
        return JsonResponse({'status': 400, 'error': 'Invalid JSON'})

    print(data)

    cur_pet.Name = data.get("pet_name")
    cur_pet.Age = data.get("pet_age")
    cur_pet.City = data.get("pet_city")
    cur_pet.Street = data.get("pet_street")
    cur_pet.ZipCode = data.get("pet_zipcode")
    cur_pet.State = data.get("pet_state")
    cur_pet.TypeofPet = data.get("pet_type")

    cur_pet.save()
    return JsonResponse({'status': 200})
