# Generated by Django 2.1.4 on 2018-12-12 00:04

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='DataBaseAccount',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('account', models.CharField(max_length=30)),
                ('name', models.CharField(max_length=30)),
                ('birthday', models.DateField()),
                ('passwd', models.CharField(max_length=30)),
                ('sharkey', models.CharField(max_length=1000)),
            ],
        ),
    ]
