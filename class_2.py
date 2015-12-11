import os, sys, operator
import re, string
import json, codecs
import math
import MySQLdb as mdb

bigarr = {}


def percentage(trainingdir):
	categories = os.listdir(trainingdir)
	percentage = {}
	total_tweet = 0
	#filter out files that are not directories
	scategories = [filename for filename in categories if os.path.isdir(trainingdir + filename)]
	#print("Counting ...")
	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		bigarr.setdefault(category, [])
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for tweet in tweets:
				bigarr[category].append(tweet)
				
		total_tweet += len(bigarr[category])
	
	for category in categories:
		percentage.setdefault(category, len(bigarr[category])*1.00/total_tweet)
	
	return percentage

def dictionary_building(trainingdir):
	categories = os.listdir(trainingdir)
	dictionary = []
	#filter out files that are not directories

	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for tweet in tweets:
				for term in tweet['text_clean'].split(" "):
					term = term.strip()
					if term not in dictionary:
						dictionary.append(term)
	return dictionary

def word_occurences(trainingdir):
	categories = os.listdir(trainingdir)
	dictionary = {}
	#filter out files that are not directories

	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		dictionary.setdefault(category, {})
		
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for tweet in tweets:
				for term in tweet['text_clean'].split(" "):
					term = term.strip()
					if term not in dictionary[category]:
						dictionary[category].setdefault(term, 0)
					dictionary[category][term] += 1
					
	return dictionary
	
def word_prob(trainingdir, wic, dictio):
	categories = os.listdir(trainingdir)
	dictionary = {}
	#remember = []
	#filter out files that are not directories

	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		dictionary.setdefault(category, {})
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for tweet in tweets:
				for term in tweet['text_clean'].split(" "):
					term = term.strip()
					for word in dictio:
						dictionary[category].setdefault(word, 0)
						if term == word:
							dictionary[category][term] += 1
						#else:
							#print("ngga ketemu %s di %s"%(word, category))
		
		for word in dictionary[category]:
			#remember.append({"category":category, "term":word, "value":dictionary[category][term]})
			#if dictionary[category][word] > 0:
			#	dictionary[category][word] = dictionary[category][term]*1.0/wic[category]
			dictionary[category][word] = (dictionary[category][word] + 1)*1.0/(wic[category] + len(dictio))
	
			#else:
			#	print("%s %s" % (word, category))
				#dictionary[category][word] = (dictionary[category][term] + 1)*1.00/(wic[category] + len(dictio))

	#for category in categories:
	#	for rem in remember:
	#		if rem['category'] == category:
			#	dictionary[category][rem['term']] = (rem['value'] + 1)*1.0/(wic[category] + len(dictio))
				
	return dictionary
	
def word_in_category(trainingdir):
	categories = os.listdir(trainingdir)
	dictionary = {}
	#filter out files that are not directories

	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		dictionary.setdefault(category, 0)
		
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for tweet in tweets:
				for term in tweet['text_clean'].split(" "):
					term = term.strip()
					dictionary[category] += 1
					
	return dictionary

	
def call_nk(trainingdir, dictios):
	categories = os.listdir(trainingdir)
	nk = {}
	#filter out files that are not directories

	for category in categories:
		currentdir = trainingdir + category
		files = os.listdir(currentdir)
		nk.setdefault(category, {})
		for file in files:
			f = codecs.open(currentdir + '/' + file, 'r', 'iso8859-1')
			tweets = json.loads(f.read())
			for word in dictios:
				for tweet in tweets:
					for term in tweet['text_clean'].split(" "):
						term = term.strip()
						if word == term: 
							if term not in nk[category]:
								nk[category].setdefault(term, 0)
							nk[category][term] += 1
	return nk

def train(trainingdir, dictios, wo, nk):
	categories = os.listdir(trainingdir)
	#filter out files that are not directories
	res = {}
	for category in categories:
		res.setdefault(category, {})
		for word in dictios:
			if len(word) > 0 and word in nk[category] and word in wo[category]:
				cal = (nk[category][word] + 1) * 1.00 / (wo[category][word] + len(dictios))
				res[category].setdefault(word, cal)
	return res
	
def test(trainingdir, text, brain, percentages):
	categories = os.listdir(trainingdir)
	#filter out files that are not directories
	res = {}
	for category in categories:
		spl = text.split(" ")
		res.setdefault(category, 0.00)
		cal = 1.0
		for word in spl:
			word = word.strip()
			if word in brain[category]:
				cal *= brain[category][word]
				#print(categories)
				#print('%s %s' % (brain[category][word], word))
		cal *= percentages[category]
		res[category] = cal
	return sorted(res.items(), key=operator.itemgetter(1), reverse=True)[0][0]

def call_test(testdir, percent, brain):
	files = os.listdir(testdir)
	arr = []
	for file in files:
		f = codecs.open(testdir + '/' + file, 'r', 'iso8859-1')
		tweets = json.loads(f.read())
		for tweet in tweets:
			text = tweet['clean_text']
			tonal = test("train/", text, brain, percent)
			tweet['tone'] = tonal
			arr.append(tweet)
		f.close()
	print(json.dumps(arr))

percent = percentage("c:/xampp/htdocs/experiment/data/data_train_machine/")
#print(percent)
dictio = dictionary_building("c:/xampp/htdocs/experiment/data/data_train_machine/")
wordcount = word_occurences("c:/xampp/htdocs/experiment/data/data_train_machine/")
nk = call_nk("c:/xampp/htdocs/experiment/data/data_train_machine/", dictio)
wic = word_in_category("c:/xampp/htdocs/experiment/data/data_train_machine/")
brain = word_prob("c:/xampp/htdocs/experiment/data/data_train_machine/", wic, dictio)

try:
	con = mdb.connect('127.0.0.1', 'root', '', 'datamining');
	count = 0
	sql = ""
	for d in dictio:
		with con:
			
			word = d
			pos = brain['positif'][d]
			neg = brain['negatif'][d]
			net = brain['netral'][d]
			sql=("INSERT INTO word_weight(word,pos,neg,net) VALUES('%s', '%s', '%s', '%s')" % (word, pos, neg, net))
			cur = con.cursor()
			cur.execute(sql)
			count += 1
			print("%s tweets have been stored"%count)
except TypeError as e:
	print(e)
	pass
except mdb.Error as e:  
	print "Error %d: %s" % (e.args[0],e.args[1])
	print(sql)
	pass
except:
	if con:    
		con.close()
finally:
    if con:    
        con.close()
	
#text = "kalah ya kalah chelsea kalau tanding wasitnya mikedean saja kalau diklaim oleh mou pasti tidak ada yang percaya"
#call_test("test_nb", percent, brain)
#text = "jokowijkturunlah media jepang soal kereta cepat jokowi lebih pilih uang ketimbang teknologi"
#print(brain['positif']['hati'])
#print(test("train/", text, brain, percent))
#print(brain['positif']['jujur'])
#print(brain['negatif']['jujur'])
#print(brain['netral']['jujur'])
