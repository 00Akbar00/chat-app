require('dotenv').config();
const { Kafka } = require('kafkajs');

const kafka = new Kafka({
  clientId: 'kafka-service',
  brokers: [process.env.KAFKA_BROKER],
});

module.exports = kafka;
