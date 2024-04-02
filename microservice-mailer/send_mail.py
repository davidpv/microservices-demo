import pika
import json
import logging
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# Setup basic logging
logging.basicConfig(level=logging.DEBUG)

# RabbitMQ connection parameters
RABBITMQ_HOST = 'rabbitmq'
RABBITMQ_PORT = 5672
RABBITMQ_USER = 'guest'
RABBITMQ_PASSWORD = 'guest'
RABBITMQ_QUEUE = 'send_mail'

# MailHog connection parameters
MAILHOG_HOST = 'mailhog'
MAILHOG_PORT = 1025

# Connect to RabbitMQ
connection = pika.BlockingConnection(
    pika.ConnectionParameters(
        host=RABBITMQ_HOST,
        port=RABBITMQ_PORT,
        credentials=pika.PlainCredentials(RABBITMQ_USER, RABBITMQ_PASSWORD)
    )
)
channel = connection.channel()
channel.queue_declare(queue=RABBITMQ_QUEUE, durable=True)

# Define the callback function to process messages from the queue
def callback(ch, method, properties, body):
    logging.debug("DEBUG: Received message: %r" % body)
    message = json.loads(body)

    subject = message.get('subject')
    sender = message.get('sender')
    body = message.get('body')

    # Assuming the message structure includes 'recipients' as a single string of comma-separated emails
    recipients_str = message.get('recipients', '')
    recipients = [email.strip() for email in recipients_str.split(',') if email.strip()]

    logging.debug(f"DEBUG: Prepared recipients: {recipients}")

    if not recipients:
        logging.error("DEBUG: No recipients provided. Message will not be sent.")
        ch.basic_ack(delivery_tag=method.delivery_tag)
        return

    msg = MIMEMultipart('alternative')
    msg['Subject'] = subject
    msg['From'] = sender
    msg['To'] = ', '.join(recipients)
    msg.attach(MIMEText(body, 'plain'))

    try:
        with smtplib.SMTP(MAILHOG_HOST, MAILHOG_PORT) as server:
            server.sendmail(sender, recipients, msg.as_string())
            logging.info("DEBUG: Email sent successfully")
    except smtplib.SMTPRecipientsRefused as e:
        logging.error(f"DEBUG: SMTPRecipientsRefused: {e.recipients}")
    except Exception as e:
        logging.error(f"DEBUG: Error sending email: {e}")

    ch.basic_ack(delivery_tag=method.delivery_tag)

# Start consuming messages from the queue
channel.basic_consume(queue=RABBITMQ_QUEUE, on_message_callback=callback, auto_ack=False)
logging.info("DEBUG: Starting to consume messages from RabbitMQ")
channel.start_consuming()
