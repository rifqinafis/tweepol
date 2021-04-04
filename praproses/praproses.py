# -*- coding: utf-8 -*-
"""
Created on Mon Oct 19 13:41:00 2020

@author: rifqi
"""

#----------------- MySQL Connector -----------------
import mysql.connector
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="tweepol")

#----------------- Select from table 'tweet' -----------------
mycursor = mydb.cursor()
mycursor.execute("SELECT id_tweet, id_akun, full_text FROM tweet")
myresult = mycursor.fetchall()
full_text = [list(i) for i in myresult]

#----------------- Membuat list stopword -----------------
list_stopwords = []
with open('stopwords.txt', 'r', encoding='utf-8') as stopword:
    for line in stopword:
        list_stopwords.append(line.strip())

#----------------- Membuat fungsi stem -----------------
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
factory = StemmerFactory()
stemmer = factory.create_stemmer()

#----------------- Praproses data -----------------
i=0
for item in full_text:
    # Case Folding
    full_text[i][2] = full_text[i][2].lower()
        
    # Cleansing
    import re
    import string
    # remove link, mention, hastag
    full_text[i][2] = ' '.join(re.sub("([@#][A-Za-z0-9]+)|(\w+:\/\/\S+)"," ", full_text[i][2]).split())
    # remove punctuation
    full_text[i][2] = full_text[i][2].translate(str.maketrans("","",string.punctuation))
    # remove number
    full_text[i][2] = re.sub(r"\d+", "", full_text[i][2])
    # remove single char
    full_text[i][2] = re.sub(r"\b[a-zA-Z]\b", "", full_text[i][2])
    
    # Stemming
    full_text[i][2] = stemmer.stem(full_text[i][2])
    
    # Tokenization
    from nltk.tokenize import word_tokenize
    full_text[i][2] = word_tokenize(full_text[i][2])
    
    # Stopword
    full_text[i][2] = [i for i in full_text[i][2] if not i in list_stopwords]
    
    i=i+1
    
#----------------- Insert hasil preprocess ke database -----------------
mycursor = mydb.cursor()
a=0
for tweet in full_text:
    id_tweet = full_text[a][0]
    id_akun = full_text[a][1]
    text = str(full_text[a][2])
    sql = "INSERT INTO praproses (id_tweet, id_akun, full_text) VALUES (%s, %s, %s)"
    val = (id_tweet, id_akun, text)
    mycursor.execute(sql, val)
    a=a+1
mydb.commit()