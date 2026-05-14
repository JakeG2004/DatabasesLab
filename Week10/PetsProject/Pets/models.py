from django.db import models

class Pets(models.Model):
    PetID = models.IntegerField(primary_key=True)
    Name = models.CharField(max_length=32)
    Age = models.IntegerField()
    Street = models.CharField(max_length=32)
    City = models.CharField(max_length=32)
    ZipCode = models.CharField(max_length=32)
    State = models.CharField(max_length=16)
    TypeofPet = models.CharField(max_length=16)

class Owners(models.Model):
    OID = models.IntegerField(primary_key=True)
    LastName = models.CharField(max_length=32)
    Street = models.CharField(max_length=32)
    City = models.CharField(max_length=32)
    ZipCode = models.CharField(max_length=32)
    State = models.CharField(max_length=16)
    Age = models.IntegerField()
    AnnualIncome = models.IntegerField()

class Owns(models.Model):
    PetID = models.ForeignKey(Pets, on_delete=models.CASCADE)
    OID = models.ForeignKey(Owners, on_delete=models.CASCADE)
    Year = models.IntegerField()
    PetAgeatOwnership = models.IntegerField()
    PricePaid = models.IntegerField()

class Likes(models.Model):
    PetID = models.ForeignKey(Pets, on_delete=models.CASCADE)
    TypeofFood = models.CharField(max_length=32)

class Foods(models.Model):
    FoodID = models.IntegerField(primary_key=True)
    Name = models.CharField(max_length=32)
    Brand = models.CharField(max_length=32)
    TypeofFood = models.CharField(max_length=32)
    Price = models.FloatField()
    ItemWeight = models.FloatField()
    ClassofFood = models.CharField(max_length=32)

class Purchases(models.Model):
    OID = models.ForeignKey(Owners, on_delete=models.CASCADE)
    FoodID = models.ForeignKey(Foods, on_delete=models.CASCADE)
    PetID = models.ForeignKey(Pets, on_delete=models.CASCADE)
    Month = models.IntegerField()
    Year = models.IntegerField()
    Quantity = models.IntegerField()