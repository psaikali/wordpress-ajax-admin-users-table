import React from "react";
import UsersTableHeaders from "./UsersTableHeaders.js";
import { __, sprintf } from "@wordpress/i18n";

class UsersTable extends React.Component {
	renderUserRow(user) {
		const {
			ID: id,
			avatar,
			user_login,
			email,
			name,
			edit_link,
			roles
		} = user;

		return (
			<tr key={id} id={`user-${id}`}>
				<td
					className="username column-username has-row-actions column-primary"
					data-colname="Username"
				>
					<a href={edit_link}>
						<img
							src={avatar}
							alt={sprintf(
								__("Profile picture for user %1$s", "utec"),
								user_login
							)}
						/>{" "}
						<strong>{user_login}</strong>
					</a>
				</td>
				<td className="name column-name" data-colname="Name">
					{name ? name : <em>{__("Unknown", "utec")}</em>}
				</td>
				<td className="email column-email" data-colname="Email">
					<a href={`mailto:${email}`}>{email}</a>
				</td>
				<td className="role column-role" data-colname="Role">
					{Object.keys(roles)
						.map(role => {
							return roles[role];
						})
						.join(", ")}
				</td>
			</tr>
		);
	}

	render() {
		return (
			<table
				className={`wp-list-table widefat fixed striped users ${
					this.props.loading ? "loading" : ""
				}`}
			>
				<UsersTableHeaders
					onRequestChange={this.props.onRequestChange}
					request={this.props.request}
				/>
				<tbody id="the-list" data-wp-lists="list:user">
					{this.props.users.length > 0 ? (
						this.props.users.map(this.renderUserRow)
					) : (
						<tr>
							<td colSpan="4">{__("No users found.", "utec")}</td>
						</tr>
					)}
				</tbody>
			</table>
		);
	}
}

export default UsersTable;
