import React from "react";

class RolesFilter extends React.Component {
	onClickRole(event, role) {
		event.preventDefault();

		if (role.slug !== this.props.request.role) {
			this.props.onRequestChange({
				role: role.slug
			});
		}
	}

	render() {
		return (
			<nav className="roles-filter">
				<ul className="subsubsub">
					{this.props.roles.map((role, index) => {
						return (
							<li
								key={index}
								className={role.slug}
								onClick={event => this.onClickRole(event, role)}
							>
								<a
									href={role.filter_url}
									className={
										role.slug === this.props.request.role ||
										(role.slug === "all" &&
											this.props.request.role === null)
											? "current"
											: ""
									}
								>
									{role.name}{" "}
									<span className="count">
										({role.count})
									</span>
								</a>
							</li>
						);
					})}
				</ul>
			</nav>
		);
	}
}

export default RolesFilter;
