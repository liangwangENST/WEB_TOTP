# Generated by Django 2.1.4 on 2018-12-12 15:17

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('ModelDataBase', '0001_initial'),
    ]

    operations = [
        migrations.AlterField(
            model_name='databaseaccount',
            name='birthday',
            field=models.CharField(max_length=30),
        ),
    ]
