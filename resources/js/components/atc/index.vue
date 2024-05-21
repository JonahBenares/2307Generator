<script setup>
import navigation from '@/layouts/navigation.vue';
import { PencilSquareIcon, Bars3Icon, PlusIcon, MagnifyingGlassIcon, ArrowUpTrayIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/solid'
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
								<h4 class="font-bold m-0 capitalize" >Schedule of Alphanumeric Tax Codes</h4>
								<div class="flex justify-between space-x-1">
									<div class="input-group border rounded w-80">
										<div class="input-group-prepend">
											<div class="input-group-icon pt-1 pl-2 pr-2">
												<MagnifyingGlassIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></MagnifyingGlassIcon>
											</div>
										</div>
										<input type="text" class="form-control border-0 rounded-none" id="search" placeholder="Type to search..." >
									</div>
									<span class="border-l ml-2  mr-1"></span>
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowTopRightOnSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowTopRightOnSquareIcon>
											<span>Export</span>
										</div>
									</button>
									<button class="btn btn-sm btn-success">
										<div class="flex justify-center space-x-2">
											<ArrowUpTrayIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-5"></ArrowUpTrayIcon>
											<span>Upload</span>
										</div>
									</button>
									<a href="/atc/new" class="btn btn-sm btn-primary ">
										<div class="flex justify-center space-x-2" >
											<PlusIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"></PlusIcon>
											<span>Add New</span>
										</div>
									</a>
								</div>
							</div>
							<table class="table table-bor table-hover rounded ">
								<thead>
									<tr>
										<th class="p-2 px-3 text-base" width="40%">Income Payments Subject to Expanded Withholding Tax</th>
										<th class="p-2 px-3 text-base" width="10%">ATC</th>
										<th class="p-2 px-3 text-base" width="10%">Percentage</th>
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
											<a href="/atc/edit/" class="btn btn-xs btn-info btn-rounded  text-white">
												<PencilSquareIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3"></PencilSquareIcon>
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
