import React from "react";
import { render } from "react-dom";
import RolesFilter from "./components/RolesFilter.js";
import Pagination from "./components/Pagination.js";
import UsersTable from "./components/UsersTable.js";

class App extends React.Component {
	constructor(props) {
		super(props);
		this.onRequestChange = this.onRequestChange.bind(this);
		//this.onPaginationChange = this.onPaginationChange.bind(this);

		this.state = {
			pagination: window.utec.pagination || null,
			request: window.utec.request || null,
			previousRequest: null,
			roles: window.utec.roles || null,
			users: window.utec.users || null
		};
	}

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
				request: newRequest
			};
		});

		this.updateUsers(newRequest);
	}

	// onPaginationChange(changePagination, update = true) {
	// 	let oldRequest = this.state.request;
	// 	let newRequest = {
	// 		...this.state.request,
	// 		paged: changePagination.current_page
	// 	};

	// 	this.setState(() => {
	// 		return {
	// 			previousRequest: oldRequest,
	// 			request: newRequest
	// 		};
	// 	});

	// 	if (update) {
	// 		this.updateUsers(newRequest);
	// 	}
	// }

	updateUsers(newRequest) {
		let ajax_url = `${window.utec.api.rest_url}utec/v1/get-users`;
		let data = {
			request: newRequest
		};

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
					console.log("error !");
				} else {
					this.setState(() => {
						return {
							pagination: response.pagination,
							request: response.request,
							users: response.users
						};
					});
				}
			});
	}

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