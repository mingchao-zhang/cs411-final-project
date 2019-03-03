# Generated by Django 2.1.7 on 2019-03-03 09:09

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Sample',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('Food_ID', models.CharField(max_length=200)),
                ('UPC', models.CharField(max_length=200)),
                ('Product_Name', models.CharField(max_length=200)),
                ('Food_Group', models.CharField(max_length=200)),
                ('Calories', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Total_Carbohydrates', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Protein', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Total_Fat', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Sodium', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Cholesterol', models.DecimalField(decimal_places=5, max_digits=20)),
                ('Sugars', models.DecimalField(decimal_places=5, max_digits=20)),
            ],
        ),
    ]
