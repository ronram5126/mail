<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<div>
		<NcModal

			@close="closeModal"
			name="Name inside modal">
			<div class="modal__content">
				<h2>Please enter your name</h2>
				<div class="form-group">
					<NcTextField label="First Name" :value.sync="firstName" />
				</div>
				<div class="form-group">
					<NcTextField label="Last Name" :value.sync="lastName" />
				</div>
				<div class="form-group">
					<label for="pizza">What is the most important pizza item?</label>
					<NcSelect input-id="pizza" :options="['Cheese', 'Tomatos', 'Pineapples']" v-model="pizza" />
				</div>

				<NcButton
					:disabled="!firstName || !lastName || !pizza"
					@click="closeModal"
					type="primary">
					Submit
				</NcButton>
			</div>
		</NcModal>
	</div>
</template>
<script>
import { ref } from 'vue'
import {NcButton, NcModal, NcSelect, NcTextField} from "@nextcloud/vue";

export default {
	components: [
		NcModal,
		NcButton,
		NcTextField,
		NcSelect,
	],
	// setup() {
	// 	return {
	// 		// modalRef: ref(null),
	// 	}
	// },
	props: {
		filter: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			modal: false,
			firstName: '',
			lastName: '',
			pizza: [],
		}
	},
	methods: {
		showModal() {
			this.firstName = ''
			this.lastName = ''
			this.modal = true
		},
		closeModal() {
			this.modal = false
		}
	}
}
</script>
<style scoped>
.modal__content {
	margin: 50px;
}

.modal__content h2 {
	text-align: center;
}

.form-group {
	margin: calc(var(--default-grid-baseline) * 4) 0;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
}
</style>
