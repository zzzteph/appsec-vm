from flask import Flask, request
import random
import pickle
import codecs
import json
import sqlite3
from  zlib import compress, decompress
import datetime 
from flask import render_template
from flask import make_response, jsonify

app = Flask(__name__)
 
class User(object):
    def __init__(self, email, mark, date):
        self.id = random.randint(1,100000)
        self.email = email
        self.mark = mark
        self.date = date
    def __str__(self):
        return "id:{} email:{} mark:{} date:{}".format(self.id, self.email, self.mark,self.date)

@app.route("/")
def index():
    rand_questions = rand_list(5, questions)
    return render_template('index.html', qs_list=rand_questions)
    
 

@app.route("/answers",  methods=['POST'])
def check_answers():
    user_cookie = request.cookies.get('userID')
    email= request.form['userEmail']
    now = datetime.datetime.now()
    answers={}

    for key, value in request.form.items():
        if key.find('answer')== 0: 
            answers[key[6:]]=value
            
    if user_cookie is None:
        return set_results(email, answers)   
    else:
        user_res = pickle.loads(decompress(codecs.decode(user_cookie.encode(), "base64")))
        if user_res.date != now.day: 
            return set_results(email, answers)
            
        else:
            return jsonify({"error" : "1"})
            

def set_results(email, answers):
    now = datetime.datetime.now()
    mark=0

    for key, value in answers.items():
        try:
            if (questions[int(key)].correct==value):
                mark=mark+1
        except (KeyError, ValueError):
            pass

    user = User(email, mark, now.day)

    comp_user = compress(pickle.dumps(user))
    ser_user = codecs.encode(comp_user, "base64").decode()
    resp = make_response('{"result": %d}'%(mark))
    resp.headers['Content-type'] = 'application/json; charset=utf-8'
    resp.set_cookie('userID', ser_user)   

    return resp

def rand_list(count,qs):
    new_list=[]
    for i in range(0, count):
        r = random.randrange(1, len(qs))
        new_list.append(qs[r])

    return new_list

class Question:
    def __init__(self, q_id, text, all_answers, correct_answer):
        self.id = q_id
        self.text = text

        self.correct = correct_answer
        self.all_answers = all_answers

def read_from_db():
    connection = sqlite3.connect('q.db')
    c = connection.cursor()

    questions = {}
    for row in c.execute('SELECT * FROM questions'):
        text = row[1]
        answers = [row[2],
                   row[3],
                   row[4],
                   row[5]]
        correct = row[6]
        q_id=int(row[0])
        if correct in answers:
            questions[q_id]=Question(q_id, text, answers, correct)
        else:
            print('correct not in answers:' + str(row))

    connection.commit()
    connection.close()
    return questions


if __name__ == "__main__":
    questions = read_from_db()
    app.run(host='0.0.0.0', port=8080)
else:
    questions = read_from_db()