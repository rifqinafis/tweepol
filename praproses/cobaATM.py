# -*- coding: utf-8 -*-
"""
Created on Mon Oct 19 17:09:20 2020

@author: rifqi
"""

#----------------- MySQL Connector -----------------
import mysql.connector
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="tweepol")

#----------------- Select from table praproses, akun -----------------
mycursor = mydb.cursor()
mycursor.execute("SELECT akun.username, praproses.id_tweet FROM akun, praproses WHERE akun.id_akun = praproses.id_akun")
myresult = mycursor.fetchall()
author = [list(i) for i in myresult]

#----------------- Select id_tweet from table praproses -----------------
mycursor = mydb.cursor()
mycursor.execute("SELECT id_tweet FROM praproses")
myresult1 = mycursor.fetchall()
doc_ids = [str(i) for i in myresult1]

# Remove punctuation from doc_ids list
import string 
i=0
for item in doc_ids:
    doc_ids[i] = doc_ids[i].translate(str.maketrans("","",string.punctuation))   
    i=i+1

#----------------- Select full_text from table praproses -----------------
mycursor = mydb.cursor()
mycursor.execute("SELECT full_text FROM praproses")
myresult2 = mycursor.fetchall()
docs = [str(i) for i in myresult2]

# Remove punctuation and tokenize docs list
from nltk.tokenize import word_tokenize 
i=0
for item in docs:   
    docs[i] = docs[i].translate(str.maketrans("","",string.punctuation))   
    docs[i] = word_tokenize(docs[i])
    i=i+1

#----------------- Membuat author2doc dictionary -----------------
author2doc = dict()
for contents in author:
    if contents[0] in author2doc:
        author2doc[contents[0]].append(contents[1])
    else:
        author2doc[contents[0]] = [contents[1]]

# Merubah id_tweet(str) menjadi id_tweet(int)
doc_id_dict = dict(zip(doc_ids, range(len(doc_ids))))
for a, a_doc_ids in author2doc.items():
    for i, doc_id in enumerate(a_doc_ids):
        author2doc[a][i] = doc_id_dict[doc_id]

#----------------- Membuat Dictionary dan Corpus -----------------
from gensim.corpora import Dictionary
dictionary = Dictionary(docs)
max_freq = 0.5
min_wordcount = 10
dictionary.filter_extremes(no_below=min_wordcount, no_above=max_freq)
_ = dictionary[0]
corpus = [dictionary.doc2bow(doc) for doc in docs]

# INPUT DICTIONARY
# dictt = dictionary.cfs
# mycursor = mydb.cursor()
# a=0
# for tweet in dictt:
#     test1 = a
#     test2 = dictt[a]
#     sql = "INSERT INTO wordcloud (id_words, freq) VALUES (%s, %s)"
#     val = (test1, test2)
#     mycursor.execute(sql, val)
#     a=a+1
# mydb.commit()

#----------------- Create Logging -----------------
import logging
logger = logging.getLogger()
fhandler = logging.FileHandler(filename='TesFixBanget.log', mode='a')
formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
fhandler.setFormatter(formatter)
logger.addHandler(fhandler)
logger.setLevel(logging.DEBUG)

#----------------- Author Topic Modelling -----------------
from gensim.models import AuthorTopicModel
for x in range(1,20):
    model = AuthorTopicModel(corpus=corpus, num_topics=x, id2word=dictionary.id2token, 
            author2doc=author2doc, passes=100, eval_every=12, iterations=10)

# Saving Model
model.save('modelfixbanget.atmodel')

# Load Model
model = AuthorTopicModel.load('zPalingFixModel.atmodel')

# Print top topics
from pprint import pprint
top_topics = model.top_topics(model.corpus)
pprint(top_topics)
model.show_topic(0)
model.show_topic(1)
model.show_topic(2)

# Memberi label pada topik
topic_labels = ['RUU Indonesia','Ucapan syukur saat pandemi','Ekonomi saat pandemi']
for topic in model.show_topics(num_topics=3):
    print('Label: ' + topic_labels[topic[0]])
    words = ''
    for word, prob in model.show_topic(topic[0]):
        words += word + ' '
    print('Words: ' + words)
    print()

# Mencetak author beserta topiknya
def show_author(name):
    print('\n%s' % name)
    print('Docs:', model.author2doc[name])
    print('Topics:')
    pprint([(topic_labels[topic[0]], topic[1]) for topic in model[name]])
show_author('Rerie_Moerdijat')