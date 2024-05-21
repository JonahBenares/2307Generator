<script setup>
	import navigation from '@/layouts/navigation.vue';
	import { CheckCircleIcon, ExclamationCircleIcon, SparklesIcon, PlusIcon, XMarkIcon, MagnifyingGlassIcon, InboxArrowDownIcon, EyeIcon, PrinterIcon} from '@heroicons/vue/24/solid'
	import {onMounted, ref} from "vue";
	import { useRouter } from "vue-router";
	const router = useRouter()
	
</script>

<template>
    <navigation>
		<div class="container-fluid px-4 py-3">
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="px-4 pt-4">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Date From</label>
										<input type="date" class="form-control border">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Date To</label>
										<input type="date" class="form-control border">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Payee's Name</label>
										<select class="form-control border">
											<option value="">Select Payee</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">ATC</label>
										<select class="form-control border">
											<option value="">Select ATC</option>
										</select>
									</div>
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Income Payments Subject to Expanded Withholding Tax</label>
										<textarea name="" id="" cols="30" rows="5" class="form-control border !bg-gray-50" disabled></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="" class="mb-0 text-sm">Amount</label>
										<input type="text" class="form-control border">
									</div>
								</div>
							</div>
							<!-- <div class="row">
								<div class="col-lg-12">
									<table class="table table-bordered">
										<tr class="bg-gray-50">
											<td colspan="3" class="text-center">Amount of Income Payments</td>
										</tr>
										<tr class="bg-gray-50">
											<td>1st Month of the Quarter</td>
											<td>2nd Month of the Quarter</td>
											<td>3rd Month of the Quarter</td>
										</tr>
										<tr>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
										</tr>
										<tr>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
										</tr>
										<tr>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
										</tr>
										<tr>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
										</tr>
										<tr>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
											<td class="p-0"><input type="text" class="form-control text-center"></td>
										</tr>
									</table>
								</div>
							</div> -->
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group flex space-x-2">
										<input type="checkbox">
										<label for="" class="mb-0 text-sm">Include Corporate Accountant's Signature</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-0">
										<label for="" class="mb-0 text-sm">Reference Number</label>
										<input type="text" class="form-control border">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card h-full">
						<div class="mx-4 mt-4 p-3 h-full rounded overflow-y-hidden hover:overflow-y-scroll bg-gray-200 shadow-inner">
							<div class="card w-full mb-2 !shadow hover:bg-yellow-100">
								<div class="row">
									<div class="col-lg-10  cursor-pointer">
										<a href="" class="!no-underline text-gray-700 hover:text-gray-700 ">
											<div class="truncate overflow-ellipsis text-base font-bold leading-tight">Payee's Name asdasdasdasd as dasdasdasd daasd sdasd</div>
											<div class="text-xs leading-tight">10/10/10/ - 10/10/10/</div>
										</a>
									</div>
									<div class="col-lg-2">
										<div class="flex justify-end">
											<a href="/print" class="mt-1">
												<PrinterIcon fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"></PrinterIcon>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="px-4 pb-4">
							<a href="" class="btn btn-sm btn-primary btn-block">Add New</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card">
						<div class="px-4 pb-4">
							<a href="/print" class="btn btn-sm btn-success btn-block">Print All</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </navigation>
</template>
