import os
from flask import *
from flask_mysqldb import MySQL
import MySQLdb.cursors
import datetime as dt
import cv2
from deepface import DeepFace
import pandas as pd
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt

app = Flask(__name__)
camera = cv2.VideoCapture(0)

app = Flask(__name__)
app.secret_key = '1ABBCD##'
app.config['SESSION_TYPE'] = 'filesystem'
app.config['MYSQL_HOST'] = "localhost"
app.config['MYSQL_USER'] = "root"
app.config['MYSQL_PASSWORD'] = ""
app.config['MYSQL_DB'] = "addb"
mysql = MySQL(app)


@app.route('/apanel')
def apanel():
    inven_url = ["templates/admin_panel/inventable.html"]
    return render_template('admin_panel/admin_panel.html', inventory_url=inven_url[0])


@app.route('/')
def admin():
    return render_template('index.html')


# -------------------------------------------------------

# ======================================================
# For Face Verification for Employee
@app.route('/emp_recog')
def face_verification1():
    emp_user = session_user()
    vid = cv2.VideoCapture(0)
    emp_img_directory = "static/images/employees/" + emp_user + ".jpg"
    emp_org_directory = "static/images/employees/Originals/" + emp_user + ".jpg"
    while (True):
        ret, frame = vid.read()
        cv2.imshow(emp_user, frame)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            cv2.imwrite(emp_img_directory, frame)
            break
    vid.release()
    cv2.destroyAllWindows()

    backends = [
        'opencv',
        'ssd',
        'dlib',
        'mtcnn',
        'retinaface',
        'mediapipe'
    ]

    try:

        obj = DeepFace.verify(img1_path=emp_org_directory,
                              img2_path=emp_img_directory,
                              detector_backend=backends[0]
                              )
        if obj['verified'] == True:
            rec_data = recent_transac()
            os.remove(emp_img_directory)
            return render_template('user_panel/user_panel.html', rc_data=rec_data, obj = obj,tb_t_transactions1 = tb_t_transactions1(),tb_t_inventory1 = tb_t_inventory1(), act_emp1 = act_emp1(),act_cst1 = act_cst1(),t_due_inrs1 = t_due_inrs1(), t_due_acc1 = t_due_acc1()    )
        
        else:
            os.remove(emp_img_directory)
            msg = "Please align the Camera Perfectly"
            session.pop('user_name', None)
            for i in ['is_loggedin', 'level', 'user_name']:
                session.pop(i, None)
            return render_template('user_panel/check_face.html' , msg = msg)
    except Exception as e:
        return redirect(url_for("admin_login"))



# ==========================================================
# For Employee Face Registration
@app.route('/emp_face_reg', methods=['GET', 'POST'])
def emp_face_reg():
    if request.method == 'POST':
        emp_name = request.form['u_username']
        vid = cv2.VideoCapture(0)
        emp_org_directory = "static/images/employees/Originals/" + emp_name + ".jpg"
        while (True):
            ret, frame = vid.read()
            cv2.imshow(emp_name, frame)
            if cv2.waitKey(1) & 0xFF == ord('q'):
                cv2.imwrite(emp_org_directory, frame)

                break
        vid.release()
        cv2.destroyAllWindows()
    return render_template("admin_panel/addusr.html", shop=shopdata(), user_data=userdata(),emp_name = emp_name)


# -----------------------------------------------------------
# Inventory Routes
@app.route('/admin_panel/inventory')
def inventory():
    curr = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    curr.execute("SELECT * FROM inrec order by `item_id`")
    fetch_data = curr.fetchall()
    return render_template('admin_panel/inventable.html', data=fetch_data)


@app.route('/admin_panel/inven_edit', methods=['GET', 'POST'])
def inven_edit():
    value = ""
    if request.method == 'POST':
        edit = request.form['edit']
        value = edit
    return delete_inven(value)


def delete_inven(edit):
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("DELETE from `inrec` where `item_id` = {0}".format(edit))
    mysql.connection.commit()
    cursor.execute("SELECT * FROM inrec order by `item_id`")
    fetch_data = cursor.fetchall()
    value = edit
    return render_template("admin_panel/inventable.html", value1=value, data=fetch_data)


@app.route('/admin_panel/inven_edit_qty', methods=['GET', 'POST'])
def qty_edit():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    form_data = {}
    if request.method == "POST":
        qty_val = request.form['qty_val']
        qty_set = request.form['qty_set']
        cursor.execute('UPDATE `inrec` SET `qty`= {0} WHERE `item_id` = {1}'.format(qty_val, qty_set))
        mysql.connection.commit()
        cursor.execute("SELECT * FROM inrec order by `item_id`")
        fetch_data = cursor.fetchall()
        form_data = fetch_data
    return render_template('admin_panel/inventable.html', data=form_data)


# -----------------------------------------------------------------------

def userdata():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * from `usrctrl`")
    usr_data = cursor.fetchall()
    return usr_data


# Manage User
@app.route('/admin_panel/manage_user')
def manage_user():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT `shop_name` FROM `shoprec`")
    shop_data = cursor.fetchall()
    cursor.execute("SELECT * from `usrctrl`")
    usr_data = cursor.fetchall()
    return render_template("admin_panel/addusr.html", shop=shopdata(), user_data=userdata())


def shopdata():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT `shop_name` FROM `shoprec`")
    shop_data = cursor.fetchall()
    return shop_data


@app.route('/admin_panel/add_member', methods=['GET', 'POST'])
def add_user():
    if request.method == 'POST':
        u_loginname = request.form['u_loginname']
        u_username = request.form['u_username']
        u_password = request.form['u_password']
        u_sname = request.form['u_sname']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute(
            "INSERT INTO `usrctrl`(`s_name`, `name`, `u_name`, `u_password`,`a_name`) VALUES ('{0}','{1}','{2}','{3}','phani')".format(
                u_sname, u_loginname, u_username, u_password))
        mysql.connection.commit()
    return render_template("admin_panel/addusr.html", shop=shopdata(), user_data=userdata())


@app.route('/admin_panel/rem_member', methods=['GET', 'POST'])
def rem_member():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    if request.method == "POST":
        rem_user_btn = request.form['rem_user_btn']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("DELETE FROM `usrctrl` WHERE `u_name` ='{0}'".format(rem_user_btn))
        mysql.connection.commit()
    return render_template('admin_panel/addusr.html', shop=shopdata(), user_data=userdata())


# ------------------------------------------------------------------
# Transaction History
@app.route('/admin_panel/transac_history')
def transac_hist():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute('SELECT * FROM `invdb1` WHERE `total` >0 and `due` != "None"')
    transac_data = cursor.fetchall()
    return render_template('admin_panel/transac_hist/index.html', transac_history=transac_data)


# -------------------------------------------------------------------
def due_details():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute('SELECT * FROM `invdb1` where `due` >0')
    data = cursor.fetchall()
    return data


# Manage Dues
@app.route('/admin_panel/manage_dues')
def manage_dues():
    return render_template('admin_panel/transac_hist/index1.html', manage_due=due_details())


@app.route('/admin_panel/manage_dues/delete', methods=['GET','POST'])
def delete_due():
    if request.method == 'POST':
        inv_id = request.form['prt_inv']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('UPDATE `invdb1` set `due` = 0 where `invoice_id` = "{0}"'.format(inv_id))
    return render_template('admin_panel/transac_hist/index1.html', manage_due=due_details())
# --------------------------------------------------------------------
# Manage Customers
@app.route('/admin_panel/manage_custmr')
def manage_cust():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT `u_name` FROM `usrctrl`")
    emp_name = cursor.fetchall()
    return render_template('admin_panel/addcstmr.html', employee_name=emp_name, cust_data=cust_db())


def cust_db():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * from `cstmrdb`")
    cust_db = cursor.fetchall()
    return cust_db


@app.route('/admin_panel/add_custmr', methods=['GET', 'POST'])
def add_cust():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT `shop_name` FROM `shoprec`")
    shop_data = cursor.fetchall()
    if request.method == "POST":
        c_custname = request.form['c_custname']
        c_comp_name = request.form['c_comp_name']
        c_mno = request.form['c_mno']
        c_email = request.form['c_email']
        u_sname = request.form['u_sname']
        cursor.execute(
            "INSERT INTO `cstmrdb`(`cust_name`, `cust_no`, `cust_email`, `u_name`,`a_name`,`comp_name`) VALUES ('{0}','{1}','{2}','{3}','phani','{4}')".format(
                c_custname, c_mno, c_email, u_sname, c_comp_name))
        mysql.connection.commit()
        cursor.execute("SELECT `u_name` FROM `usrctrl`")
        emp_name = cursor.fetchall()
    return render_template('admin_panel/addcstmr.html', shop=shop_data, employee_name=emp_name, cust_data=cust_db())


@app.route('/admin_panel/rem_custmr', methods=['GET', 'POST'])
def rem_cust():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    if request.method == 'POST':
        rem_user = request.form['rem_user']
        cursor.execute("DELETE FROM `cstmrdb` where `cust_name` = '{0}'".format(rem_user))
        mysql.connection.commit()
    cursor.execute("SELECT `u_name` FROM `usrctrl`")
    emp_name = cursor.fetchall()
    return render_template('admin_panel/addcstmr.html', employee_name=emp_name, cust_data=cust_db())


# ===================================================================================

# ------------------------------------------------------------------------------------
# -----------------------------


# Inventory Routes
@app.route('/user_panel/inventory')
def user_inventory():
    curr = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    curr.execute("SELECT * FROM inrec order by `item_id`")
    fetch_data = curr.fetchall()
    return render_template('user_panel/inventable.html', data=fetch_data)


# -----------------------------------------------------------------------
# ---------------------------------------------------------------------
# Admin Panel Interface

def admin_authenticate():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    temp_id = session['user_name']
    cursor.execute("SELECT * FROM `admctrl` where `username` = '{0}'".format(temp_id))
    f_id = cursor.fetchone()
    if f_id:
        return True
    else:
        False

def tb_t_transactions():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`total`) as `t_transac` from `invdb1`')
        data = cursor.fetchone()
    return data['t_transac']

def tb_t_inventory():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`item_name`)*sum(`qty`) as `tbox_qty` from `inrec`')
        data = cursor.fetchone()
    return data['tbox_qty']

def act_emp():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`u_name`) as `emp_count` from `usrctrl`')
        data = cursor.fetchone()
    return data['emp_count']

def act_cst():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`cust_name`) as `cstmr_count` from `cstmrdb`')
        data = cursor.fetchone()
    return data['cstmr_count']

def t_due_inrs():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT sum(`total`) as `cstmr_count` from `invdb1` where `due`>0')
        data = cursor.fetchone()
    return data['cstmr_count']
       
def t_due_acc():
    if admin_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("SELECT count(`cust_name`) as `due_cust` from `cstmrdb` where `due`>0 group by 'cust_name'")
        data = cursor.fetchone()
    return data['due_cust']     

# ==========================================================================
# Admin Panel Interface

def user_authenticate():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    temp_id = session['user_name']
    cursor.execute("SELECT * FROM `usrctrl` where `u_name` = '{0}'".format(temp_id))
    f_id = cursor.fetchone()
    if f_id:
        return True
    else:
        False

def tb_t_transactions1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("SELECT count(`total`) as `t_transac` from `invdb1` where `u_name` = '{0}' ".format(session['user_name']))
        data = cursor.fetchone()
    return data['t_transac']

def tb_t_inventory1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`item_name`)*sum(`qty`) as `tbox_qty` from `inrec`')
        data = cursor.fetchone()
    return data['tbox_qty']

def act_emp1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`u_name`) as `emp_count` from `usrctrl`')
        data = cursor.fetchone()
    return data['emp_count']

def act_cst1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT count(`cust_name`) as `cstmr_count` from `cstmrdb`')
        data = cursor.fetchone()
    return data['cstmr_count']

def t_due_inrs1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute('SELECT sum(`total`) as `cstmr_count` from `invdb1` where `due`>0')
        data = cursor.fetchone()
    return data['cstmr_count']
       
def t_due_acc1():
    if user_authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("SELECT count(`cust_name`) as `due_cust` from `cstmrdb` where `due`>0 group by 'cust_name'")
        data = cursor.fetchone()
    return data['due_cust']     



# =========================================================
# Login Route
@app.route('/admin_login', methods=['GET', 'POST'])
def admin_login():
    if request.method == 'POST':
        uname = request.form['Admin_name']
        password = request.form['Admin_pass']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("select * from admctrl where `username` = % s and password = % s", (uname, password))
        istrue = cursor.fetchone()
        data1 = istrue
        if istrue:
            session['is_loggedin'] = True
            session['level'] = 1
            session['user_name'] = istrue['username']
            
            return render_template('admin_panel/admin_panel.html',t_transac = tb_t_transactions(), tb_t_inventory = tb_t_inventory(), act_emp = act_emp(), act_cst = act_cst(), t_due_inrs =  t_due_inrs(), t_due_acc = t_due_acc())
        else:
            return "incorrect"

    return render_template('index.html')

@app.route('/admin_panel')
def a_panel():
    return render_template('admin_panel/admin_panel.html',t_transac = tb_t_transactions(), tb_t_inventory = tb_t_inventory(), act_emp = act_emp(), act_cst = act_cst(), t_due_inrs =  t_due_inrs(), t_due_acc = t_due_acc())

def session_user():
    return session['user_name']


@app.route('/user_login', methods=['GET', 'POST'])
def user_login():
    if request.method == 'POST':
        uname = request.form['User_name']
        password = request.form['User_pass']
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("select * from `usrctrl` where `u_name` = % s and `u_password` = % s", (uname, password))
        istrue = cursor.fetchone()
        data1 = istrue
        if istrue:
            session['is_loggedin'] = "True"
            session['level'] = "2"
            session['user_name'] = istrue['u_name']
            rec_data = recent_transac()
            return redirect(url_for('face_verification1'))
        else:
            return "incorrect"

    return render_template('index.html')


@app.route('/logout')
def logout():
    session.pop('user_name', None)
    for i in ['is_loggedin', 'level', 'user_name']:
        session.pop(i, None)
    return redirect(url_for("admin_login"))






# ---------
# ---------------------------------------------------------------------
# Stats
# For plots
def emp_transac():
    a_name = session['user_name']
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("select `u_name`,`total` from `invdb1` group by `u_name`")
    data = cursor.fetchall()
    return data

def emp_performance():
    e_data = emp_transac()
    employees = []
    transactions = []
    colors = (0.2, # redness
        0.4, # greenness
        0.2, # blueness
        0.6 # transparency
        ) 
    for i in e_data :
        employees.append(i['u_name'])
        transactions.append(i['total'])
   
    plt.barh(employees,transactions, color = "#AB80CE")
    plt.savefig('static/images/stats/stat1.jpg',dpi=400)
    plt.close()
    #-------------------------------------------------------------------------
# for Last 3 Months
def last_three_months():
    datetime = dt.datetime.now()
    today = datetime.strftime("%Y-%m-%d")
    month_01 = datetime.strftime("%m")
    f_mon = datetime.strftime("%Y-%m")+'-01'
    s_mon = datetime.strftime("%Y")+"-"+str((int(month_01)-1)) +"-01"
    t_mon = datetime.strftime("%Y")+"-"+str((int(month_01)-2)) + "-01"
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT sum(`total`) as `total` FROM `invdb1` where `issue_date` BETWEEN '{0}' AND '{1}'".format(f_mon,today))
    first_mon = cursor.fetchone()
    cursor.execute("SELECT sum(`total`) as `total` FROM `invdb1` where `issue_date` BETWEEN '{0}' AND '{1}'".format(s_mon,f_mon))
    second_mon = cursor.fetchone()
    cursor.execute("SELECT sum(`total`) as `total` FROM `invdb1` where `issue_date` BETWEEN '{0}' AND '{1}'".format(t_mon,s_mon))
    third_mon = cursor.fetchone()
    none_stat = 0
    if first_mon == None:
        first_mon = 0
    elif second_mon == None:
        second_mon = 0
    elif third_mon == None:
        third_mon = 0
    else:
        none_stat = 1
    months = []
    for i in f_mon,s_mon,t_mon:
        months.append(i)
        Months_sum = []
    for i in first_mon['total'],second_mon['total'],third_mon['total']:
         Months_sum.append(i)
    colors = (0.2, # redness
            0.4, # greenness
            0.2, # blueness
            0.6 # transparency
            ) 
    plt.barh(months,Months_sum, color="#8E80CE")
    plt.savefig('static/images/stats/stat2.jpg',dpi=400)
    plt.close()


  #-------------------------------------------------------------------------
# for top 5 Customers
def top_5_customers():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT `cust_name`,SUM(`total`) as `total_price` FROM `invdb1` GROUP BY `cust_name` order by `total_price` desc limit 5")
    top_5 = cursor.fetchall()
    name = []
    total = []
    for i in top_5:
        name.append(i['cust_name'])
        total.append(i['total_price'])
    colors = (0.2, # redness
            0.4, # greenness
            0.2, # blueness
            0.6 # transparency
            ) 
    plt.bar(name,total,color = "#80CE81")
    plt.savefig('static/images/stats/stat3.jpg',dpi=400)
    plt.close()

  #-------------------------------------------------------------------------
# Transaction Count for Invoice
def t_count():
    total_count = []
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` between 0 and 20000 ")
    t_c1 = cursor.fetchone()
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` between 20000 and 40000 ")
    t_c2 = cursor.fetchone()
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` between 40000 and 60000 ")
    t_c3 = cursor.fetchone()
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` between 60000 and 80000 ")
    t_c4 = cursor.fetchone()
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` between 80000 and 100000 ")
    t_c5 = cursor.fetchone()
    cursor.execute("select count(`total`) as `total_price` from `invdb1` where `total` > 100000 ")
    t_c6 = cursor.fetchone()

    for i in t_c1['total_price'],t_c2['total_price'],t_c3['total_price'],t_c4['total_price'],t_c5['total_price'],t_c6['total_price']:
        total_count.append(i)
    colors = (0.2, # redness
            0.4, # greenness
            0.2, # blueness
            0.6 # transparency
            ) 
    t_count_range = ["0 - 20000",'20000 - 40000', '40000 - 60000','60000 - 80000','80000 - 100000','>100000']
    plt.bar(t_count_range,total_count,color="#CE8A80")
    plt.savefig('static/images/stats/stat4.jpg',dpi=400)
    plt.close()



# ---------
# ---------------------------------------------------------------------
@app.route('/stats')
def admin_stats():
    emp_performance()
    last_three_months()
    top_5_customers()
    t_count()
    return render_template('admin_panel/stats.html' )








# ---------

    






















# -----------------
# -------------------------------------------------------------
# Sale
@app.route('/user_panel/authenticate')
def authenticate():
    user_db = {}
    user = session['user_name']
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * from `usrctrl` where `u_name` = '{0}'".format(user))
    user_db = cursor.fetchone()
    if user_db:
        return True
    else:
        return False


def user_cust_db():
    if authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        cursor.execute("SELECT * from `cstmrdb`")
        cust_data = cursor.fetchall()
        return cust_data
    else:
        return "Unauthorised"


@app.route('/user_panel/sale')
def sale():
    cust_data = user_cust_db()
    return render_template('user_panel/invoicesys/index.html', customer_data=cust_data)


@app.route('/user_panel/add_inv_det', methods=['GET', 'POST'])
def add_inv():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    if authenticate():
        if request.method == 'POST':
            invoc_no = request.form['invno']
            invcust_name = request.form['invcust_name']
            cust_accntno = request.form['cust_accntno']
            session['inv_no'] = invoc_no
            cursor.execute(
                "INSERT INTO `invdb1`(`invoice_id`, `cust_name`,`account_no`) VALUES ('{0}','{1}','{2}')".format(
                    invoc_no, invcust_name, cust_accntno))
            mysql.connection.commit()
            return redirect(url_for('pro_inv'))
    else:
        return render_template('user_panel/invoicesys/index.html')


@app.route('/user_panel/pro_inv')
def pro_inv():
    if authenticate():
        inv_no = db1_data()
        customer_data = from_cust_data()
    return render_template('user_panel/invoicesys/invadd.html', customer_data=customer_data, invoce_no=inv_no,
                           inven_data=inven(), total_cost=total_cost())


def from_cust_data():
    db1 = db1_data()
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * FROM `cstmrdb` WHERE `cust_name` = '{0}'".format(db1['cust_name']))
    data = cursor.fetchone()
    return data


def inven():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * FROM `inrec`")
    data = cursor.fetchall()
    return data


def db1_data():
    inv_no = session['inv_no']
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * FROM `invdb1` WHERE `invoice_id` = '{0}'".format(inv_no))
    db1_data1 = cursor.fetchone()
    return db1_data1


def db0_data():
    inv_no = session['inv_no']
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT * FROM `invdb` WHERE `invoice_id` = '{0}'".format(inv_no))
    data = cursor.fetchall()
    return data


@app.route('/user_panel/pro_inv/table')
def inven_table():
    i = 0
    return render_template('user_panel/invoicesys/invoctable.html', data=db0_data(), i=i)


def total_cost():
    inv_no = session['inv_no']
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    cursor.execute("SELECT sum(`i_price`) as total_price FROM `invdb` WHERE `invoice_id` = '{0}'".format(inv_no))
    data = cursor.fetchone()
    return data


@app.route('/user_panel/pro_inv/remove', methods=['GET', 'POST'])
def delete_invoc_rec():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    if request.method == 'POST':
        inv_no = session['inv_no']
        delbtn1 = request.form['delbtn1']
        r_qty = request.form['r_qty']
        cursor.execute("UPDATE `inrec` SET `qty` = '{0}' WHERE `item_name`= '{1}'".format(r_qty, delbtn1))
        mysql.connection.commit()
        cursor.execute("DELETE FROM `invdb` WHERE `invoice_id` = '{0}' AND `item_name` = '{1}'".format(inv_no, delbtn1))
        mysql.connection.commit()
    i = 0
    return render_template('user_panel/invoicesys/invoctable.html', data=db0_data(), i=i)


@app.route('/user_panel/pro_inv/submit', methods=['GET', 'POST'])
def add_to_cart():
    if authenticate():
        cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
        db1data = db1_data()
        inv_no = db1data['invoice_id']
        if request.method == 'POST':
            by_item_name = request.form['by_item_name']
            by_item_id = request.form['by_item_id']
            qty = request.form['item_qty']
            if by_item_name == 'Select Item Name' and by_item_id == '':
                return False
            elif by_item_id != 'Select Item Name':
                cursor.execute("SELECT * FROM `inrec`WHERE `item_name` = '{0}'".format(by_item_name))
                fetch_item = cursor.fetchone()
                item_name = fetch_item['item_name']
                item_price = fetch_item['cost']
                item_qty = fetch_item['qty']
                upd_qty = int(item_qty) - int(qty)
                titem_price = float(qty) * float(item_price)
                if (upd_qty <= -1):
                    return "Insuffcient"
                else:
                    cursor.execute(
                        "INSERT INTO `invdb`(`invoice_id`, `item_name`, `i_qty`, `i_price`) VALUES ('{0}','{1}','{2}','{3}')".format(
                            inv_no, item_name, qty, titem_price))
                    mysql.connection.commit()
                    if True:
                        cursor.execute(
                            "UPDATE `inrec` SET `qty`='{0}' WHERE `item_name` = '{1}'".format(upd_qty, item_name))
                        mysql.connection.commit()
            else:
                return None
        else:
            return "Insufficient Quantity"
    return render_template('user_panel/invoicesys/invadd.html', customer_data=from_cust_data(), invoce_no=db1_data(),
                           inven_data=inven(), total_cost=total_cost())


@app.route('/user_panel/comp_transac', methods=['GET', 'POST'])
def complete_transac():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    if authenticate:
        if request.method == "POST":
            inv_id = db1_data()
            inv_no = inv_id['invoice_id']
            tax = request.form['t_tax']
            t_disc = request.form['t_disc']
            t_deposit = request.form['t_deposit']
            t_amount = request.form['t_amount']
            t_due = request.form['t_due']
            issue_date = dt.datetime.now()
            today = issue_date.strftime("%Y-%m-%d")
            day_val = request.form['day_val']
            mon_val = request.form['mon_val']
            year_val = request.form['year_val']
            due_date = year_val + "-" + mon_val + "-" + day_val
            u_name = session['user_name']
            cursor.execute(
                "UPDATE `invdb1` SET `tax`='{0}',`discount`='{2}',`total`='{3}',`deposit`='{4}', `due`='{5}',`issue_date`= '{6}' ,`due_date`='{7}',`u_name` ='{8}'   WHERE `invoice_id` = '{1}'".format(
                    tax, inv_no, t_disc, t_amount, t_deposit, t_due, today, due_date, u_name))
            mysql.connection.commit()
        return render_template('user_panel/invoicesys/invadd.html', customer_data=from_cust_data(),
                               invoce_no=db1_data(), inven_data=inven(), total_cost=total_cost())


# ------------------------------------------------------------------
# Transaction History For Employee
@app.route('/user_panel/transac_history')
def user_transac_hist():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    user = session['user_name']
    cursor.execute("SELECT * FROM `invdb1` WHERE `u_name` = '{0}' and `total` >0 ".format(user))
    transac_data = cursor.fetchall()
    return render_template('user_panel/transac_hist/index.html', transac_history=transac_data)


def recent_transac():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    user = session['user_name']
    cursor.execute("SELECT * FROM `invdb1` WHERE `u_name` = '{0}' and `total` >0 LIMIT 10".format(user))
    data = cursor.fetchall()
    return data


# -----------------------------


# Inventory Routes for User
@app.route('/user_panel/inventory')
def user_inventory1():
    curr = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
    curr.execute("SELECT * FROM inrec order by `item_id`")
    fetch_data = curr.fetchall()
    return render_template('user_panel/inventable.html', data=fetch_data)


# @app.route('/user_panel/inven_edit', methods=['GET','POST'])
# def user_inven_edit():
#     value = ""
#     if request.method == 'POST':
#         edit = request.form['edit']
#         value = edit
#     return delete_inven(value)

# def delete_inven(edit):
#     cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
#     cursor.execute("DELETE from `inrec` where `item_id` = {0}".format(edit))
#     mysql.connection.commit()
#     cursor.execute("SELECT * FROM inrec order by `item_id`")
#     fetch_data = cursor.fetchall()
#     value = edit
#     return render_template("user_panel/inventable.html",value1 = value,data = fetch_data)

# @app.route('/user_panel/inven_edit_qty', methods=['GET','POST'])
# def qty_edit():
#     cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)
#     form_data = {}
#     if request.method == "POST":
#         qty_val = request.form['qty_val']
#         qty_set = request.form['qty_set']
#         cursor.execute('UPDATE `inrec` SET `qty`= {0} WHERE `item_id` = {1}'.format(qty_val,qty_set))
#         mysql.connection.commit()
#         cursor.execute("SELECT * FROM inrec order by `item_id`")
#         fetch_data = cursor.fetchall()
#         form_data = fetch_data
#     return render_template('admin_panel/inventable.html',data = form_data)
# ======================================================

if __name__ == '__main__':
    app.debug = True
    app.run()
 
