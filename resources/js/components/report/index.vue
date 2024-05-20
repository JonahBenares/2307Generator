<script setup>
import navigation from '@/layouts/navigation.vue';
import { PencilSquareIcon, Bars3Icon, PlusIcon, MagnifyingGlassIcon, PrinterIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/solid'
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRouter } from "vue-router";



</script>

<template>
    <navigation>
		<div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-md-12 col-lg-12 ">
					<div class="card">
						<!-- <h5 class="font-bold " >Supplier</h5> -->
						<div class="px-4 py-4">
							<div class="flex justify-between pb-2 mt-2 mb-2">
								<h4 class="font-bold m-0 capitalize" >Report</h4>
								<div class="flex justify-between space-x-1">
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowTopRightOnSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowTopRightOnSquareIcon>
											<span>Export</span>
										</div>
									</button>
								</div>
							</div>
							<div class="flex justify-between space-x-2 mb-2 rounded border p-3 ">
								<div class="w-2/12">
									<label class="mb-0 text-sm">Period From</label>
									<input type="date" class="form-control border rounded-none">
								</div>
								<div class="w-2/12">
									<label class="mb-0 text-sm">Period To</label>
									<input type="date" class="form-control border rounded-none">
								</div>
								<div class="w-2/12">
									<label class="mb-0 text-sm">Date Encoded</label>
									<input type="date" class="form-control border rounded-none">
								</div>
								<div class="w-5/12">
									<label class="mb-0 text-sm">Payee</label>
									<select type="date" class="form-control border rounded-none ">
										<option value="" class="w-96">Select Paye asdas dasdaseasdasdasdasd</option>
									</select>
								</div>
								<div class="w-1/12">
									<br>
									<a href="#" class="btn btn-sm btn-primary w-full">
										<div class="flex justify-center space-x-1" >
											<MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></MagnifyingGlassIcon>
											<span>Search</span>
										</div>
									</a>
								</div>
							</div>
							<table class="table table-bor table-hover rounded ">
								<thead>
									<tr>
										<th class="p-2 px-3 text-base" width="40%">Payee's Name</th>
										<th class="p-2 px-3 text-base" width="10%">Date Encoded</th>
										<th class="p-2 px-3 text-base" width="10%">Period</th>
										<th class="p-2 px-3 text-base" width="1%" align="center">
											<Bars3Icon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></Bars3Icon>
										</th>
									</tr>
								</thead>
								<tbody>
									<!-- <tr>
										<td colspan="3" class="bg-yellow-100"></td>
									</tr> -->
									<tr >
										<td class="p-1 px-3">asd</td>
										<td class="p-1 px-3">asd</td>
										<td class="p-1 px-3">asd</td>
										<td class="p-1 px-3">
											<a href="/print" class="btn btn-xs btn-success btn-rounded  text-white">
												<PrinterIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PrinterIcon>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
