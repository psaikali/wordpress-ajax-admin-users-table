import React from "react";
import { render } from "react-dom";
import RolesFilter from "./components/RolesFilter.js";
import Pagination from "./components/Pagination.js";
import UsersTable from "./components/UsersTable.js";
import { setLocaleData } from "@wordpress/i18n";
import "isomorphic-fetch";
import "promise-polyfill/src/polyfill";

class App extends React.Component {
	constructor(props) {
		super(props);
		this.onRequestChange = this.onRequestChange.bind(this);

		this.state = {
			loading: false,
			pagination: window.utec.pagination || null,
			request: window.utec.request || null,
			previousRequest: null,
			roles: window.utec.roles || null,
			users: window.utec.users || null
		};

		setLocaleData(utec.translation, "utec");
	}

	/**
	 * Request change happens when role, order, orderby or page are clicked
	 * and we need to update data.
	 * @param {object} changeRequest
	 */
	onRequestChange(changeRequest) {
		let oldRequest = this.state.request;
		let newRequest = {
			...this.state.request,
			...changeRequest
		};

		// If we are updating role, order or orderby, reset back to 1st page
		if (typeof changeRequest.paged === "undefined") {
			newRequest.paged = 1;
		}

		this.setState(() => {
			return {
				previousRequest: oldRequest,
				request: newRequest,
				loading: true
			};
		});

		this.updateUsers(newRequest);
	}

	/**
	 * AJAX call to get new data from our WP
	 * @param {object} newRequest
	 */
	updateUsers(newRequest) {
		const ajax_url = `${window.utec.api.rest_url}utec/v1/get-users`;
		const data = { request: newRequest };

		fetch(ajax_url, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": window.utec.api.nonce
			},
			body: JSON.stringify(data),
			credentials: "include"
		})
			.then(res => res.json())
			.then(response => {
				if (typeof response.users === "undefined") {
					// Some kind of error, re-install previous request.
					this.setState(() => {
						return {
							request: this.state.previousRequest,
							loading: false
						};
					});
				} else {
					// Everything went well, let's update data and URL.
					this.setState(() => {
						return {
							pagination: response.pagination,
							request: response.request,
							users: response.users,
							loading: false
						};
					});

					this.updateUrl();
				}
			});
	}

	/**
	 * Keep the URL updated with proper $_GET parameters,
	 * so reloading the page will gives us the correct data on page load.
	 */
	updateUrl() {
		if (!!(window.history && history.pushState)) {
			let url = window.utec.admin_url;

			Object.keys(this.state.request).map(key => {
				if (!(key === "role" && this.state.request[key] === null)) {
					url += `&${key}=${this.state.request[key]}`;
				}
			});

			window.history.pushState(
				{
					data: this.state
				},
				document.title,
				url
			);
		}
	}

	/**
	 * Render our app layout
	 */
	render() {
		return (
			<div className="app">
				<div className="before-table">
					<RolesFilter
						roles={this.state.roles}
						request={this.state.request}
						onRequestChange={this.onRequestChange}
					/>
					<Pagination
						pagination={this.state.pagination}
						onRequestChange={this.onRequestChange}
					/>
				</div>

				<UsersTable
					users={this.state.users}
					request={this.state.request}
					loading={this.state.loading}
					onRequestChange={this.onRequestChange}
				/>

				<div className="after-table">
					<Pagination
						pagination={this.state.pagination}
						onRequestChange={this.onRequestChange}
					/>
				</div>
			</div>
		);
	}
}

render(<App />, document.getElementById("utec-app"));
