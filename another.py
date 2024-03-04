from flask import *
from flask_mysqldb import MySQL
import cv2
import MySQLdb.cursors


def delete_inven(edit):
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("DELETE from `inrec` where `item_id` = {0}".format(edit))
    mysql.connection.commit()
    value = edit
    return render_template("admin_panel/inventable.html",value1 = value)
