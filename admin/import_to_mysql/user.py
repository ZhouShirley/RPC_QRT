import csv
import MySQLdb

mydb = MySQLdb.connect(host='localhost',
	user='shirley',
	passwd='',
    db='test_coach')
cursor = mydb.cursor()

csv_data = csv.reader(file('users_python.csv'))
for row in csv_data:

    cursor.execute('INSERT INTO employee(emp_id, \
		leader_id, first, last )' \
		'VALUES("%s", "%s", "%s", "%s")', 
		row)
#close the connection to the database.
mydb.commit()
cursor.close()
