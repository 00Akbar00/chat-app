require('dotenv').config();
const { Kafka } = require('kafkajs');

const kafka = new Kafka({
  clientId: 'discord-node-service',
  brokers: [process.env.KAFKA_BROKER],
});

const consumer = kafka.consumer({ groupId: 'discord-group' });

const run = async () => {
  await consumer.connect();
  await consumer.subscribe({ topic: process.env.TOPIC, fromBeginning: false });

  console.log('Kafka consumer running...');
  await consumer.run({
    eachMessage: async ({ topic, partition, message }) => {
      const msg = message.value.toString();
      console.log(`Received [${topic}]: ${msg}`);
    },
  });
};

run().catch(console.error);
