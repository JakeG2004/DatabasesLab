from django.shortcuts import render, redirect
from django.http import HttpResponse, JsonResponse, HttpRequest
from django.db.models import Q
from django.views.decorators.http import require_POST

import json

from .models import *

def index(request):
    return render(request, "lab4/index.html")

def pets_db(request: HttpRequest) -> HttpResponse:
    pets = Pets.objects.all()
    return render(request, "lab4/pets_db.html", {'pets': pets})

def owners_db(request: HttpRequest) -> HttpResponse:
    owners = Owners.objects.all()
    return render(request, "lab4/owners_db.html", {'owners': owners})

def owns_db(request: HttpRequest) -> HttpResponse:
    owns = Owns.objects.all()
    return render(request, "lab4/owns_db.html", {'owns': owns})

def likes_db(request: HttpRequest) -> HttpResponse:
    likes = Likes.objects.all()
    return render(request, "lab4/likes_db.html", {'likes': likes})

def foods_db(request: HttpRequest) -> HttpResponse:
    foods = Foods.objects.all()
    return render(request, "lab4/foods_db.html", {'foods': foods})

def purchases_db(request: HttpRequest) -> HttpResponse:
    purchases = Purchases.objects.all()
    return render(request, "lab4/purchases_db.html", {'purchases': purchases})

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

    return redirect('lab4:pets_db')

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

@require_POST
def add_owner(request: HttpRequest) -> HttpResponse:

    # Get POST data
    data = request.POST
    print(data)
    name = data.get("owner_name")
    age = data.get("owner_age")
    street = data.get("owner_street")
    city = data.get("owner_city")
    zipcode = data.get("owner_zip")
    state = data.get("owner_state")
    income = data.get("owner_annual_income")

    # Create new object
    new_owner = Owners(
        LastName=name,
        Age=age,
        Street=street,
        City=city,
        ZipCode=zipcode,
        State=state,
        AnnualIncome=income,
    )

    # Save it
    new_owner.save()

    return redirect('lab4:owners_db')

@require_POST
def delete_owner(request: HttpRequest, OID: int) -> JsonResponse:
    cur_owner = Owners.objects.filter(OID=OID).first()

    if(not cur_owner):
        return JsonResponse({'status': 500})
    
    cur_owner.delete()
    return JsonResponse({'status': 200})

@require_POST
def update_owner(request: HttpRequest, OID: int) -> JsonResponse:
    cur_owner = Owners.objects.filter(OID=OID).first()

    if(not cur_owner):
        return JsonResponse({'status': 500})
    
    try:
        data = json.loads(request.body)
    except json.JSONDecodeError:
        return JsonResponse({'status': 400, 'error': 'Invalid JSON'})

    cur_owner.Name = data.get("name")
    cur_owner.Age = data.get("age")
    cur_owner.City = data.get("city")
    cur_owner.Street = data.get("street")
    cur_owner.ZipCode = data.get("zipcode")
    cur_owner.State = data.get("state")
    cur_owner.AnnualIncome = data.get("income")

    cur_owner.save()
    return JsonResponse({'status': 200})

@require_POST
def add_own(request: HttpRequest) -> HttpResponse:

    # Get POST data
    data = request.POST
    petid = data.get("petid")
    oid = data.get("oid")
    year = data.get("year")
    petageatownership = data.get("petageatownership")
    pricepaid = data.get("pricepaid")

    # Create new object
    new_own = Owns(
        PetID=Pets.objects.filter(PetID=petid).first(),
        OID=Owners.objects.filter(OID=oid).first(),
        Year=year,
        PetAgeatOwnership=petageatownership,
        PricePaid=pricepaid,
    )

    # Save it
    new_own.save()

    return redirect('lab4:owns_db')

@require_POST
def delete_own(request: HttpRequest, OID: int, PetID: int) -> JsonResponse:
    cur_own = Owns.objects.filter(OID=OID, PetID=PetID).first()

    if(not cur_own):
        return JsonResponse({'status': 500})
    
    cur_own.delete()
    return JsonResponse({'status': 200})

@require_POST
def update_own(request: HttpRequest, OID: int, PetID: int) -> JsonResponse:
    cur_own = Owns.objects.filter(OID=OID, PetID=PetID).first()

    if(not cur_own):
        return JsonResponse({'status': 500})
    
    try:
        data = json.loads(request.body)
    except json.JSONDecodeError:
        return JsonResponse({'status': 400, 'error': 'Invalid JSON'})

    cur_own.Year = data.get("year")
    cur_own.PetAgeatOwnership = data.get("petageatownpetageatownership")
    cur_own.PricePaid = data.get("pricepaid")

    cur_own.save()
    return JsonResponse({'status': 200})

@require_POST
def add_like(request: HttpRequest) -> HttpResponse:

    # Get POST data
    data = request.POST
    petid = data.get("petid")
    typeoffood = data.get("typeoffood")

    # Create new object
    new_like = Likes(
        PetID=Pets.objects.filter(PetID=petid).first(),
        TypeofFood=typeoffood,
    )

    # Save it
    new_like.save()

    return redirect('lab4:likes_db')

@require_POST
def delete_like(request: HttpRequest, PetID: int) -> JsonResponse:
    cur_like = Likes.objects.filter(PetID=PetID).first()

    if(not cur_like):
        return JsonResponse({'status': 500})
    
    cur_like.delete()
    return JsonResponse({'status': 200})

@require_POST
def update_like(request: HttpRequest, PetID: int) -> JsonResponse:
    cur_like = Likes.objects.filter(PetID=PetID).first()

    if(not cur_like):
        return JsonResponse({'status': 500})
    
    try:
        data = json.loads(request.body)
    except json.JSONDecodeError:
        return JsonResponse({'status': 400, 'error': 'Invalid JSON'})

    cur_like.TypeofFood = data.get("typeoffood")

    cur_like.save()
    return JsonResponse({'status': 200})

@require_POST
def add_food(request: HttpRequest) -> HttpResponse:
    data = request.POST
    new_food = Foods(
        FoodID=data.get("foodid"),
        Name=data.get("name"),
        Brand=data.get("brand"),
        TypeofFood=data.get("typeoffood"),
        Price=data.get("price"),
        ItemWeight=data.get("itemweight"),
        ClassofFood=data.get("classoffood")
    )
    new_food.save()
    return redirect('lab4:foods_db')

@require_POST
def delete_food(request: HttpRequest, foodId: int) -> JsonResponse:
    Foods.objects.filter(FoodID=foodId).delete()
    return JsonResponse({'status': 200})

@require_POST
def update_food(request: HttpRequest, foodId: int) -> JsonResponse:
    cur_food = Foods.objects.filter(FoodID=foodId).first()
    if not cur_food: return JsonResponse({'status': 500})
    
    data = json.loads(request.body)
    cur_food.Name = data.get("name")
    cur_food.Brand = data.get("brand")
    cur_food.Price = data.get("price")
    cur_food.TypeofFood = data.get("typeoffood")
    cur_food.ItemWeight = data.get("itemweight")
    cur_food.ClassofFood = data.get("classoffood")
    cur_food.save()
    return JsonResponse({'status': 200})

@require_POST
def add_purchase(request: HttpRequest) -> HttpResponse:
    data = request.POST
    new_purchase = Purchases(
        OID_id=data.get("oid"),
        FoodID_id=data.get("foodid"),
        PetID_id=data.get("petid"),
        Month=data.get("month"),
        Year=data.get("year"),
        Quantity=data.get("quantity")
    )
    new_purchase.save()
    return redirect('lab4:purchases_db')

@require_POST
def delete_purchase(request: HttpRequest, pk: int) -> JsonResponse:
    # Since Purchases doesn't have a custom PK in your model, Django uses 'id'
    Purchases.objects.filter(id=pk).delete()
    return JsonResponse({'status': 200})

@require_POST
def update_purchase(request: HttpRequest, pk: int) -> JsonResponse:
    cur_purchase = Purchases.objects.filter(id=pk).first()

    if not cur_purchase:
        return JsonResponse({'status': 500, 'error': 'Purchase not found'})
    
    try:
        data = json.loads(request.body)
    except json.JSONDecodeError:
        return JsonResponse({'status': 400, 'error': 'Invalid JSON'})

    # Update the fields
    cur_purchase.Month = data.get("month")
    cur_purchase.Year = data.get("year")
    cur_purchase.Quantity = data.get("quantity")

    cur_purchase.save()
    return JsonResponse({'status': 200})

