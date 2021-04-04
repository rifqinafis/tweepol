# -*- coding: utf-8 -*-
"""
Spyder Editor

This is a temporary script file.
"""
#----------------- Koneksi dengan database MySQL -----------------
import mysql.connector
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="tweepol"
)

#----------------- Menyimpan token API ke dalam variabel -----------------
# consumer_key = " insert your key "
# consumer_secret = " insert your key "
# access_key = " insert your key "
# access_secret = " insert your key "

#----------------- Proses Crawling data -----------------
import tweepy
auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_key, access_secret)
api = tweepy.API(auth)
nama = 'jokowi'
alltweets = []
new_tweets = api.user_timeline(screen_name = nama, count=200, tweet_mode="extended")
alltweets.extend(new_tweets)
oldest = alltweets[-1].id - 1
while len(new_tweets) > 0:
        print("Sedang mengambil tweet ...")
        new_tweets = api.user_timeline(screen_name = nama, count=200, max_id=oldest, tweet_mode="extended")
        alltweets.extend(new_tweets)
        oldest = alltweets[-1].id - 1
        print(f"...{len(alltweets)} tweet telah disimpan")
    
#----------------- Mengubah data ke bentuk Array -----------------
import datetime
outtweets = [[tweet.id_str, tweet.user.id, tweet.created_at, tweet.full_text]
             for tweet in alltweets if 'RT' not in tweet.full_text and datetime.datetime(2020, 1, 1) < tweet.created_at < datetime.datetime(2020, 10, 15)]

#----------------- Query Insert untuk menambahkan data akun ke database -----------------
mycursor = mydb.cursor()
for tweet in alltweets:
    id_akun = tweet.user.id
    username = tweet.user.screen_name
    following = tweet.user.friends_count
    followers = tweet.user.followers_count
    gender = ""
    usia = ""
    sql = "INSERT INTO akun (id_akun, username, following, followers, gender, usia) VALUES (%s, %s, %s, %s, %s, %s)"
    val = (id_akun, username, following, followers, gender, usia)
mycursor.execute(sql, val)
mydb.commit()

#----------------- Query Insert untuk menambahkan data tweet ke database -----------------
mycursor = mydb.cursor()
a=0
for tweet in outtweets:
    id_tweet = outtweets[a][0]
    id_akun = outtweets[a][1]
    created_at = outtweets[a][2]
    full_text = outtweets[a][3]
    sql = "INSERT INTO tweet (id_tweet, id_akun, created_at, full_text) VALUES (%s, %s, %s, %s)"
    val = (id_tweet, id_akun, created_at, full_text)
    mycursor.execute(sql, val)
    a=a+1     
mydb.commit()