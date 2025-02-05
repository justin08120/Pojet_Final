from flask import Flask, request, render_template, redirect, url_for
from flask_sqlalchemy import SQLAlchimy
import random

app = Flask (__name__)
app.config['SQLALCHIMY_DATABASE_URI'] = 'sqlite://quiz.db'
app.config['SQLALCHIMY_TRACK_MODIFICATION'] = False
db = SQLAlchimy(app)

class infos(db.Mobel):
    id = db.Columm(db.Integer, primary_key = True)
    zone = db.Columm(db.String(50), nullable=False)
    etat = db.Columm(db.String(50), nullable=False)