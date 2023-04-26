
import pandas as pd
import numpy as np
from datetime import datetime, timedelta
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split

def predict_process_time(arrival_date, distance):

    # Load the dataset into a pandas DataFrame
    df = pd.read_csv('dataset.csv')

    # Convert date columns to datetime format
    df['arrival_date'] = pd.to_datetime(df['arrival_date'], format='%B %d, %Y')
    df['arrival_date'] = pd.to_numeric(df['arrival_date'])
    df['distance'] = (df['distance'] - df['distance'].mean()) / df['distance'].std()

    # Drop columns that are not needed for the analysis
    df = df.drop(columns=['delivery_time', 'id','delivery_date','consignee_name', 'entry_number', 'bl_number', 'shipment_details', 'origin_of_shipment', 'origin', 'destination','weight','process_started','process_finished', 'pickedup_date', 'shipment_size','shipping_line'])

    #df['delivery_date'] = pd.to_numeric(df['delivery_date'])

    X = df.drop(columns=['process_time'])

    y = df['process_time']
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.4, random_state=42)


    # Train a random forest model on the training set
    rf = RandomForestRegressor(n_estimators=100, random_state=42)
    rf.fit(X_train, y_train)

    X_predict = [[arrival_date.timestamp(), distance]]

    # Use the trained model to make predictions on the test set
    y_pred = rf.predict(X_predict)

    return y_pred


def predict_delivery_time(arrival_date, distance, process_time):

    # Load the dataset into a pandas DataFrame
    df = pd.read_csv('dataset.csv')

    # Convert date columns to datetime format
    df['arrival_date'] = pd.to_datetime(df['arrival_date'], format='%B %d, %Y')
    df['arrival_date'] = pd.to_numeric(df['arrival_date'])
    df['distance'] = (df['distance'] - df['distance'].mean()) / df['distance'].std()

    # Drop columns that are not needed for the analysis
    df = df.drop(columns=['id','delivery_date','consignee_name', 'entry_number', 'bl_number', 'shipment_details', 'origin_of_shipment', 'origin', 'destination','weight','process_started','process_finished', 'pickedup_date', 'shipment_size','shipping_line'])

    # Train a random forest model on the entire dataset
    X = df.drop(columns=['delivery_time'])
    y = df['delivery_time']
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.4, random_state=42)


    # Train a random forest model on the training set
    rf = RandomForestRegressor(n_estimators=100, random_state=42)
    rf.fit(X_train, y_train)

    arrival_date_timestamp = arrival_date.timestamp()

    new_data = pd.DataFrame({
        'arrival_date': [arrival_date_timestamp],
        'distance': [distance],
        'process_time': [process_time],
    })

    # Use the trained model to make predictions on the test set
    y_pred = rf.predict(new_data)

    return y_pred

import requests

arrival_date_str = 'April 11, 2023'
distance = 1000

response = requests.post('http://127.0.0.1:8000/predict', json={
    'arrival_date': arrival_date_str,
    'distance': distance,
})

if response.status_code == 200:
    data = response.json()
    print(data['process_time'])
    print(data['delivery_time'])
    print(data['delivery_date'])
else:
    print('Error:', response.status_code)
