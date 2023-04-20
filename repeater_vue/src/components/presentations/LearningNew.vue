<template>
  <h1>Nauka nowych słów z kursu: {{ courseId }}</h1>
  <h3>Limit dnia: {{ dayLimit }}, limit tury: {{ batchLimit }}</h3>

  <div v-if="learningEnding()">
    <summary-phase></summary-phase>
  </div>
  <div v-else>
    <learn-present></learn-present>
  </div>
</template>

<script>
import LearnPresent from "./LearnPresent.vue";
import SummaryPhase from "./SummaryPhase.vue";

export default {
  name: "learning-new",
  components: {
    "learn-present": LearnPresent,
    "summary-phase": SummaryPhase,
  },
  data() {
    return {
      wordId: 0,
      courseId: this.$route.params.courseId,
      dayLimit: this.$store.getters["option/getLearningDayLimit"],
      batchLimit: this.$store.getters["option/getLearningBatchLimit"],
      readiness: false,
    };
  },
  setup() {},
  methods: {
    learningEnding() {
      return this.$store.getters["learning/getEndLearning"];
    },
  },
  created() {},
};
</script>

<style scoped></style>
