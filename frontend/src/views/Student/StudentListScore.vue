<template>
  <v-card>
    <v-tabs v-model="tab" bg-color="primary">
      <v-tab v-for="month in months" :key="month.value" :value="month.value">{{
        month.name
      }}</v-tab>
    </v-tabs>
    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="one">
          <v-table fixed-header height="300px">
            <thead>
              <tr>
                <th class="text-left">Khhmer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Physic</th>
                <th class="text-left">Chemistry</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Total</th>
                <th class="text-left">Average</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr v-for="item in desserts" :key="item.name">
                <td>{{ item.name }}</td>
                <td>{{ item.calories }}</td>
              </tr> -->
              <tr>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
              </tr>
            </tbody>
          </v-table>
        </v-window-item>

        <v-window-item value="two"> Two </v-window-item>

        <v-window-item value="three"> Three </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      tab: "one",
      months: [
        { name: "January", value: "one" },
        { name: "February", value: "two" },
        { name: "March", value: "three" },
        { name: "April", value: "four" },
        { name: "May", value: "five" },
        { name: "June", value: "six" },
        { name: "July", value: "seven" },
        { name: "August", value: "eight" },
        { name: "September", value: "nine" },
        { name: "October", value: "ten" },
        { name: "November", value: "eleven" },
        { name: "December", value: "twelve" },
      ],
    };
  },
};
</script>

<style>
</style>